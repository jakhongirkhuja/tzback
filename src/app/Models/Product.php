<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'unit_price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class)->withPivot('quantity', 'unit_price');
    }

    public function storages()
    {
        return $this->belongsToMany(Storage::class)->withPivot('quantity');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'unit_price');
    }
}
