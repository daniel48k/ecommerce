<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public $table = 'products';

    public const FILE_PATH = 'products';

    public $fillable = ['title', 'description', 'price', 'photo', 'sub_category_id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'description' => 'required',
        'sub_category_id' => 'required',
        'price' => 'required',
    ];

    /**
     * Get the sub_category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_category()
    {
        return $this->belongsTo(Sub_category::class, 'sub_category_id', 'id');
    }

    /**
     * Get all of the carts for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }


    public function getPriceAttribute()
    {
        return round($this->attributes['price'] * 100) / 100;
    }

    public function getPhotoUrlAttribute()
    {
        if(empty($this->photo))return asset('no_image.webp');
        return asset($this->photo);
    }

}
