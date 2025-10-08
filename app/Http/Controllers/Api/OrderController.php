<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('auth:api');
    }

    public function index(int $venueId, Request $request): JsonResponse
    {
        $status = $request->query('status');
        $orders = $this->orderService->getOrdersByVenue($venueId, $status);

        return $this->sendResponse($orders, 'Orders retrieved successfully');
    }

    public function store(OrderRequest $request, int $venueId): JsonResponse
    {
        $data = array_merge($request->validated(), [
            'venue_id' => $venueId,
            'employee_id' => auth()->id(),
            'employee_name' => auth()->user()->full_name,
        ]);

        $order = $this->orderService->createOrder($data);
        return $this->sendResponse($order, 'Order created successfully', 201);
    }

    public function show(int $venueId, int $orderId): JsonResponse
    {
        $order = $this->orderService->getOrderWithRelations($orderId);

        if (!$order || $order->venue_id != $venueId) {
            return $this->sendError('Order not found or does not belong to this venue');
        }

        return $this->sendResponse($order, 'Order retrieved successfully');
    }

    public function update(OrderRequest $request, int $venueId, int $orderId): JsonResponse
    {
        $order = $this->orderService->getOrder($orderId);

        if (!$order || $order->venue_id != $venueId) {
            return $this->sendError('Order not found or does not belong to this venue');
        }

        $updated = $this->orderService->updateOrder($orderId, $request->validated());

        if (!$updated) {
            return $this->sendError('Order could not be updated');
        }

        return $this->sendResponse([], 'Order updated successfully');
    }

    public function updateStatus(int $venueId, int $orderId, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        $order = $this->orderService->getOrder($orderId);

        if (!$order || $order->venue_id != $venueId) {
            return $this->sendError('Order not found or does not belong to this venue');
        }

        $updated = $this->orderService->updateOrderStatus(
            $orderId,
            $request->status,
            auth()->id()
        );

        if (!$updated) {
            return $this->sendError('Order status could not be updated');
        }

        return $this->sendResponse([], 'Order status updated successfully');
    }

    public function addItem(int $venueId, int $orderId, Request $request): JsonResponse
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $order = $this->orderService->getOrder($orderId);

        if (!$order || $order->venue_id != $venueId) {
            return $this->sendError('Order not found or does not belong to this venue');
        }

        $item = $this->orderService->addOrderItem($orderId, $request->all());

        return $this->sendResponse($item, 'Item added to order successfully', 201);
    }

    public function updateItemStatus(int $venueId, int $orderId, int $itemId, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        $order = $this->orderService->getOrder($orderId);

        if (!$order || $order->venue_id != $venueId) {
            return $this->sendError('Order not found or does not belong to this venue');
        }

        $updated = $this->orderService->updateOrderItemStatus(



            $itemId,
            $request->status,
            auth()->id()
        );

        if (!$updated) {
            return $this->sendError('Item status could not be updated');
        }

        return $this->sendResponse([], 'Item status updated successfully');
    }

    public function getKitchenOrders(int $venueId): JsonResponse
    {
        $orders = $this->orderService->getKitchenOrders($venueId);
        return $this->sendResponse($orders, 'Kitchen orders retrieved successfully');
    }

    public function getActiveTables(int $venueId): JsonResponse
    {
        $tables = $this->orderService->getActiveTables($venueId);
        return $this->sendResponse($tables, 'Active tables retrieved successfully');
    }
}
