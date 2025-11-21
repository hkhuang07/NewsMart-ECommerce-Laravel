<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getHome()
    {
		$categories = Category::with([
            'products' => function($q) { 
                // Sửa lỗi 'Product' -> 'products' và 'lastest()' -> 'latest()'
                $q->latest()->take(8);
            }
        ])->get();

        // Truyền biến $categories vào view (để lặp qua từng danh mục)
        return view('frontend.home', compact('categories'));
    }

    public function index()
    {
		// Thực hiện truy vấn tương tự cho route /home mặc định
        $categories = Category::with([
            'products' => function($q) { 
                $q->latest()->take(8);
            }
        ])->get();
        return view('frontend.home', compact('categories'));
    }
}
