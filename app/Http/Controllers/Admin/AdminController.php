<?php

namespace App\Http\Controllers\Admin;

use App\Constants\RoleConstants;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    public function index(CategoryRepository $categoryRepository, UserRepository $userRepository, ProductRepository $productRepository)
    {
        $stats['categories_count'] = $categoryRepository->allQuery()->count();
        $stats['products_count'] = $productRepository->allQuery()->count();
        $stats['clients_count'] = $userRepository->allQuery(['role'=>RoleConstants::CLIENT])->count();

        return view('backend.index')->with(['stats'=>$stats]);
    }
}
