<?php 

namespace App\Services;

use App\Models\Batch;
use App\Models\Storage;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function buyProducts(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $batch = Batch::create([
                'provider_id' => $data['provider_id'],
                'purchase_date' => now(),
                'total_cost' => $data['total_cost'],
            ]);

            foreach ($data['products'] as $productData) {
                $batch->products()->attach($productData['product_id'], [
                    'quantity' => $productData['quantity'],
                    'unit_price' => $productData['unit_price']
                ]);

                Storage::find($data['storage_id'])->increment('quantity', $productData['quantity'], [
                    'product_id' => $productData['product_id']
                ]);
            }

            return true;
        });
    }

    public function refundBatch(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $batch = Batch::findOrFail($data['batch_id']);

            foreach ($data['products'] as $productData) {
                $batchProduct = $batch->products()->where('product_id', $productData['product_id'])->first();
                $refundQuantity = min($productData['quantity'], $batchProduct->pivot->quantity);

                $batchProduct->pivot->update([
                    'quantity' => $batchProduct->pivot->quantity - $refundQuantity
                ]);

                Storage::find($data['storage_id'])->decrement('quantity', $refundQuantity, [
                    'product_id' => $productData['product_id']
                ]);
            }

            return true;
        });
    }

    public function getAvailableProducts()
    {
        return Storage::with(['products' => function ($query) {
            $query->where('quantity', '>', 0);
        }])->get();
    }

    public function orderProducts(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'client_id' => $data['client_id'],
                'storage_id' => $data['storage_id'],
                'total_price' => $data['total_price'],
            ]);

            foreach ($data['products'] as $productData) {
                $order->products()->attach($productData['product_id'], [
                    'quantity' => $productData['quantity'],
                    'unit_price' => $productData['unit_price']
                ]);

                Storage::find($data['storage_id'])->decrement('quantity', $productData['quantity'], [
                    'product_id' => $productData['product_id']
                ]);
            }

            return true;
        });
    }

    public function calculateBatchProfit()
    {
        return Batch::with(['products'])->get()->map(function ($batch) {
            $totalPurchaseCost = $batch->total_cost;
            $totalRevenue = $batch->products->sum(function ($product) {
                return $product->pivot->quantity * $product->selling_price;
            });

            return [
                'batch_id' => $batch->id,
                'profit' => $totalRevenue - $totalPurchaseCost
            ];
        });
    }
}