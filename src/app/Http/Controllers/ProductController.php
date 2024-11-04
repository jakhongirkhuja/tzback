<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $data = $request->validated();
        $result = $this->productService->buyProducts($data);
        return response()->json(['success' => $result]);
    }

    public function refundBatch(RefundBatchRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->productService->refundBatch($data);
        return response()->json(['success' => $result]);
    }

    public function getAvailableProducts(): JsonResponse
    {
        $products = $this->productService->getAvailableProducts();
        return response()->json($products);
    }

    public function orderProducts(OrderProductsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->productService->orderProducts($data);
        return response()->json(['success' => $result]);
    }

    public function calculateBatchProfit(): JsonResponse
    {
        $profits = $this->productService->calculateBatchProfit();
        return response()->json($profits);
    }
}
