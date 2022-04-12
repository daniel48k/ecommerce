<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\Log;

trait ProductFilters
{
    public function filterByCategory($category)
    {
        if (!empty($category)) {
            $this->addLeftJoin('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id');
            $this->query_filter->where('sub_categories.category_id', '=', $category);
        }
    }

    public function filterBySubCategory($sub_category)
    {
        if (!empty($sub_category)) {
            $this->query_filter->where('products.sub_category_id', '=', $sub_category);
        }
    }

    public function filterByPriceRange($price)
    {
        if (!empty($price)) {
            $price = explode('-', $price);
            $this->query_filter->whereBetween('products.price', $price);
        }
    }

}
