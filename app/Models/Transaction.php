<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }



    public function orders()
    {
        return $this->hasMany(Order::class, 'transaction_id','id');
    }
}
