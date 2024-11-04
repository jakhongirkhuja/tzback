<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'storage_id',
        'total_price',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'unit_price');
    }
}
