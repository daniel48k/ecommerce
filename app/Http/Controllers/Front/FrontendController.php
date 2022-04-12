<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**@var ProductRepository */
    protected $productRepository;

    /**@var CategoryRepository */
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home()
    {
        $products = Product::query()->orderBy('id', 'DESC')->limit(8)->get();
        $categories = Category::whereHas('sub_categories')->orderBy('name', 'ASC')->get();

        $sub_categoriesIds = $products->pluck('sub_category_id');
        $all_categories = Category::query()->join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
            ->whereIn('sub_categories.id', $sub_categoriesIds)
            ->distinct('categories.id')
            ->select('categories.*')->orderBy('name', 'ASC')->get();

        return view('frontend.index')->with(['product_lists'=>$products,'all_categories'=> $all_categories,'category_lists'=>$categories]);
    }

    public function productDetail($id)
    {
        $product_detail = $this->productRepository->find($id);
        return view('frontend.pages.product_detail')->with('product_detail', $product_detail);
    }


    public function productFilter(Request $request)
    {
        $max_price = $this->productRepository->allQuery()->max('price');
        $products = $this->productRepository->filter($request);

        return view('frontend.pages.product-grids')->with(['products'=>$products,'max_price'=>$max_price]);
    }

}
