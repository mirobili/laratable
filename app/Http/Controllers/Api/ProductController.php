<?php

namespace App\Http\Controllers\Api;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return $this->sendResponse($products, 'Products retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'product_type' => 'required|string|in:food,drink,other',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'allergens' => 'nullable|array',
            'preparation_time' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'barcode' => 'nullable|string|max:50|unique:products,barcode',
        ]);

        $product = $this->productService->createProduct($data);
        return $this->sendResponse($product, 'Product created successfully', 201);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        
        if (!$product) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product, 'Product retrieved successfully');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'product_type' => 'sometimes|string|in:food,drink,other',
            'image_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean',
            'allergens' => 'nullable|array',
            'preparation_time' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $id,
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $id,
        ]);

        $updated = $this->productService->updateProduct($id, $data);
        
        if (!$updated) {
            return $this->sendError('Product not found or could not be updated');
        }

        return $this->sendResponse([], 'Product updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->deleteProduct($id);
        
        if (!$deleted) {
            return $this->sendError('Product not found or could not be deleted');
        }

        return $this->sendResponse([], 'Product deleted successfully');
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|string|in:food,drink,other',
            'category' => 'nullable|string',
        ]);

        $products = $this->productService->searchProducts(
            $request->query('query'),
            $request->query('type'),
            $request->query('category')
        );

        return $this->sendResponse($products, 'Products retrieved successfully');
    }

    public function updateStatus(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $updated = $this->productService->updateStatus($id, $request->is_active);
        
        if (!$updated) {
            return $this->sendError('Product not found or could not be updated');
        }

        return $this->sendResponse(
            ['is_active' => $request->is_active],
            'Product status updated successfully'
        );
    }
}
