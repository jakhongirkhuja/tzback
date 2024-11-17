<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyProductsRequest;
use App\Http\Requests\RefundBatchRequest;
use App\Http\Requests\OrderProductsRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function buyProducts(BuyProductsRequest $request): JsonResponse
    {
        $this->productService->buyProducts($request->validated());
        return response()->json(['message' => 'Products purchased successfully']);
    }

    public function refundBatch(RefundBatchRequest $request): JsonResponse
    {
        $this->productService->refundBatch($request->validated());
        return response()->json(['message' => 'Batch refunded successfully']);
    }

    public function getAvailableProducts(): JsonResponse
    {
        return response()->json($this->productService->getAvailableProducts());
    }

    public function orderProducts(OrderProductsRequest $request): JsonResponse
    {
        $this->productService->orderProducts($request->validated());
        return response()->json(['message' => 'Products ordered successfully']);
    }

    public function calculateBatchProfit(): JsonResponse
    {
        return response()->json($this->productService->calculateBatchProfit());
    }
}