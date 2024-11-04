<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'contact_name',
        'phone',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
