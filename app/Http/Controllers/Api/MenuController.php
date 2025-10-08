<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MenuRequest;
use App\Services\MenuService;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
        $this->middleware('auth:api');
    }

    public function index(int $venueId): JsonResponse
    {
        $menus = $this->menuService->getMenusByVenue($venueId);
        return $this->sendResponse($menus, 'Menus retrieved successfully');
    }

    public function store(MenuRequest $request, int $venueId): JsonResponse
    {
        $data = array_merge($request->validated(), ['venue_id' => $venueId]);
        $menu = $this->menuService->createMenu($data);
        return $this->sendResponse($menu, 'Menu created successfully', 201);
    }

    public function show(int $venueId, int $menuId): JsonResponse
    {
        $menu = $this->menuService->getMenuWithRelations($menuId);
        
        if (!$menu || $menu->venue_id != $venueId) {
            return $this->sendError('Menu not found or does not belong to this venue');
        }

        return $this->sendResponse($menu, 'Menu retrieved successfully');
    }

    public function update(MenuRequest $request, int $venueId, int $menuId): JsonResponse
    {
        $menu = $this->menuService->getMenu($menuId);
        
        if (!$menu || $menu->venue_id != $venueId) {
            return $this->sendError('Menu not found or does not belong to this venue');
        }

        $updated = $this->menuService->updateMenu($menuId, $request->validated());
        
        if (!$updated) {
            return $this->sendError('Menu could not be updated');
        }

        return $this->sendResponse([], 'Menu updated successfully');
    }

    public function destroy(int $venueId, int $menuId): JsonResponse
    {
        $menu = $this->menuService->getMenu($menuId);
        
        if (!$menu || $menu->venue_id != $venueId) {
            return $this->sendError('Menu not found or does not belong to this venue');
        }

        try {
            $deleted = $this->menuService->deleteMenu($menuId);
            
            if (!$deleted) {
                return $this->sendError('Menu could not be deleted');
            }

            return $this->sendResponse([], 'Menu deleted successfully');
            
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }

    public function toggleStatus(int $venueId, int $menuId): JsonResponse
    {
        $menu = $this->menuService->getMenu($menuId);
        
        if (!$menu || $menu->venue_id != $venueId) {
            return $this->sendError('Menu not found or does not belong to this venue');
        }

        $toggled = $this->menuService->toggleMenuStatus($menuId);
        
        return $this->sendResponse(
            ['is_active' => $toggled], 
            'Menu status updated successfully'
        );
    }
}
