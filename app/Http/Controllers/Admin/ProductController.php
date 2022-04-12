<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\ImageFileUploadTrait;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Models\Category;

class ProductController extends Controller
{
    use ImageFileUploadTrait;

    /**@var  ProductRepository */
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->allQuery()->orderBy('updated_at', 'DESC')->paginate(10);
        return view('backend.product.index')->with('products', $products);
    }

    public function create()
    {
        $categories = Category::whereHas('sub_categories')->get();
        return view('backend.product.create')->with('categories', $categories);
    }

    public function store(ProductRequest $request)
    {
        $input = $request->validated();
        $input['photo'] = $this->saveFile($request, 'photo', Product::FILE_PATH);
        $this->productRepository->create($input);
        request()->session()->flash('success', 'Product Successfully added');
        return redirect()->route('products.index');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::whereHas('sub_categories')->get();

        return view('backend.product.edit')->with('product', $product)->with('categories', $categories);
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $status = $this->productRepository->updateWithPhoto($request, $id);

        if ($status) {
            request()->session()->flash('success', 'Product Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {

        if ($this->productRepository->delete($id)) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product,it is already in carts of users');
        }
        return redirect()->route('products.index');
    }
}
