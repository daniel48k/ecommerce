<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\Sub_categoryRequest;
use App\Models\Category;
use App\Repositories\Sub_categoryRepository;

class Sub_categoryController extends Controller
{
    /**@var Sub_categoryRepository */
    protected $sub_categoryRepository;

    public function __construct(Sub_categoryRepository $sub_categoryRepository)
    {
        $this->sub_categoryRepository = $sub_categoryRepository;
    }

    public function getByCategory($category_id)
    {
        return response()->json(['data' => $this->sub_categoryRepository->allQuery(['category_id' => $category_id])->get(), 'status' => 'success']);
    }

    public function getByCategoryIndex($category_id)
    {
        $sub_categories = $this->sub_categoryRepository->allQuery(['category_id' => $category_id])->paginate(10);
        return view('backend.sub_category.index')->with(['sub_categories' => $sub_categories]);
    }


    public function create()
    {
        $categories = Category::all();
        return view('backend.sub_category.create', compact('categories'));
    }

    public function store(Sub_categoryRequest $request)
    {
        $this->sub_categoryRepository->create($request->validated());
        request()->session()->flash('success', 'sub_category successfully Created');
        return redirect()->route('sub_category.index', ['id' => $request->category_id]);
    }

    public function edit($id)
    {
        $sub_category = $this->sub_categoryRepository->find($id);
        return view('backend.sub_category.edit')->with('sub_category', $sub_category);
    }

    public function update(CategoryRequest $request, $sub_category_id)
    {
        $sub_category = $this->sub_categoryRepository->update($request->validated(), $sub_category_id);
        request()->session()->flash('success', 'sub_category successfully updated');
        return redirect()->route('sub_category.index', ['id' => $sub_category->category_id]);
    }


    public function destroy($id)
    {
        $category_id = ($this->sub_categoryRepository->find($id))->category_id;
        if ($this->sub_categoryRepository->delete($id)){
            request()->session()->flash('success', 'sub_category successfully deleted');
        }
        else{
            request()->session()->flash('error', 'sub_category cannot be deleted,it has related data');
        }

        return redirect()->route('sub_category.index', ['id' => $category_id]);
    }


}
