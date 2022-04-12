<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**@var CategoryRepository */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function index()
    {
        $categories = $this->categoryRepository->allQueryWith([],[],['sub_categories'])->paginate(10);
        return view('backend.category.index')->with(['categories' => $categories]);
    }


    public function create()
    {
        return view('backend.category.create');
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->create($request->validated());
        request()->session()->flash('success', 'Category successfully Created');
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        return view('backend.category.edit')->with('category', $category);
    }

    public function update(CategoryRequest $request, $category_id)
    {
        $this->categoryRepository->update($request->validated(), $category_id);
        request()->session()->flash('success', 'Category successfully updated');
        return redirect()->route('categories.index');
    }


    public function destroy($id)
    {
        if($this->categoryRepository->delete($id)){
            request()->session()->flash('success', 'Category successfully deleted');
        }
        else{
            request()->session()->flash('error', 'Category cannot be deleted,it has related data');
        }
        return redirect()->route('categories.index');
    }

}
