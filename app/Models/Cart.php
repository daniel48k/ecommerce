<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public $table = 'carts';


    public $fillable = [
        'client_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'client_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
        'price'=>'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'client_id' => 'required',
        'product_id' => 'required',
        'quantity' => 'required',
        'price'=>'required'
    ];

    /**
     * Get the client that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    /**
     * Get the item that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    public function getAmountAttribute()
    {
        return $this->attributes['quantity'] * $this->product->price;
    }

}
