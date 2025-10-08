<?php

namespace App\Http\Controllers\Api;

use App\Services\MenuItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    protected $menuItemService;

    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
        $this->middleware('auth:api');
    }

    public function index(int $sectionId): JsonResponse
    {
        $items = $this->menuItemService->getItemsBySection($sectionId);
        return $this->sendResponse($items, 'Menu items retrieved successfully');
    }

    public function store(Request $request, int $sectionId): JsonResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'position' => 'integer|min:0',
            'description_override' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_vegetarian' => 'boolean',
            'is_vegan' => 'boolean',
            'is_gluten_free' => 'boolean',
            'is_dairy_free' => 'boolean',
            'is_nut_free' => 'boolean',
        ]);

        $data['menu_section_id'] = $sectionId;
        $item = $this->menuItemService->createItem($data);
        return $this->sendResponse($item, 'Menu item created successfully', 201);
    }

    public function update(Request $request, int $sectionId, int $itemId): JsonResponse
    {
        $data = $request->validate([
            'price' => 'sometimes|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'position' => 'sometimes|integer|min:0',
            'description_override' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_featured' => 'sometimes|boolean',
            'is_vegetarian' => 'sometimes|boolean',
            'is_vegan' => 'sometimes|boolean',
            'is_gluten_free' => 'sometimes|boolean',
            'is_dairy_free' => 'sometimes|boolean',
            'is_nut_free' => 'sometimes|boolean',
        ]);

        $updated = $this->menuItemService->updateItem($itemId, $data);
        
        if (!$updated) {
            return $this->sendError('Menu item not found or could not be updated');
        }

        return $this->sendResponse([], 'Menu item updated successfully');
    }

    public function destroy(int $sectionId, int $itemId): JsonResponse
    {
        $deleted = $this->menuItemService->deleteItem($itemId);
        
        if (!$deleted) {
            return $this->sendError('Menu item not found or could not be deleted');
        }

        return $this->sendResponse([], 'Menu item deleted successfully');
    }

    public function updateAvailability(int $sectionId, int $itemId, Request $request): JsonResponse
    {
        $request->validate([
            'is_available' => 'required|boolean',
        ]);

        $updated = $this->menuItemService->updateAvailability($itemId, $request->is_available);
        
        if (!$updated) {
            return $this->sendError('Menu item not found or could not be updated');
        }

        return $this->sendResponse(
            ['is_available' => $request->is_available],
            'Menu item availability updated successfully'
        );
    }

    public function reorder(Request $request, int $sectionId): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.position' => 'required|integer|min:0',
            'items.*.menu_section_id' => 'sometimes|exists:menu_sections,id'
        ]);

        $this->menuItemService->reorderItems($request->items);
        return $this->sendResponse([], 'Menu items reordered successfully');
    }
}
