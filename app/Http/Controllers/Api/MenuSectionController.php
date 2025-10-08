<?php

namespace App\Http\Controllers\Api;

use App\Services\MenuSectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuSectionController extends Controller
{
    protected $menuSectionService;

    public function __construct(MenuSectionService $menuSectionService)
    {
        $this->menuSectionService = $menuSectionService;
        $this->middleware('auth:api');
    }

    public function index(int $menuId): JsonResponse
    {
        $sections = $this->menuSectionService->getSectionsByMenu($menuId);
        return $this->sendResponse($sections, 'Menu sections retrieved successfully');
    }

    public function store(Request $request, int $menuId): JsonResponse
    {
        $data = $request->validate([
            'section_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data['menu_id'] = $menuId;
        $section = $this->menuSectionService->createSection($data);
        return $this->sendResponse($section, 'Menu section created successfully', 201);
    }

    public function update(Request $request, int $menuId, int $sectionId): JsonResponse
    {
        $data = $request->validate([
            'section_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'position' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean'
        ]);

        $updated = $this->menuSectionService->updateSection($sectionId, $data);
        
        if (!$updated) {
            return $this->sendError('Menu section not found or could not be updated');
        }

        return $this->sendResponse([], 'Menu section updated successfully');
    }

    public function destroy(int $menuId, int $sectionId): JsonResponse
    {
        $deleted = $this->menuSectionService->deleteSection($sectionId);
        
        if (!$deleted) {
            return $this->sendError('Menu section not found or could not be deleted');
        }

        return $this->sendResponse([], 'Menu section deleted successfully');
    }

    public function reorder(Request $request, int $menuId): JsonResponse
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:menu_sections,id',
            'sections.*.position' => 'required|integer|min:0'
        ]);

        $this->menuSectionService->reorderSections($request->sections);
        return $this->sendResponse([], 'Menu sections reordered successfully');
    }
}
