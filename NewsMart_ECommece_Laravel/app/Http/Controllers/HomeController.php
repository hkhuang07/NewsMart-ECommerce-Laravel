<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
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
		$brands = Brand::orderBy('name')->get();
		$categories = Category::with([
            'products' => function($q) { 
                // Sửa lỗi 'Product' -> 'products' và 'lastest()' -> 'latest()'
                $q->latest()->take(8);
            }
        ])->get();

        // Truyền biến $categories vào view (để lặp qua từng danh mục)
        return view('frontend.home', compact('categories','brands'));
    }

    public function index()
    {
		// Thực hiện truy vấn tương tự cho route /home mặc định
        $brands = Brand::orderBy('name')->get();
		$categories = Category::with([
            'products' => function($q) { 
                $q->latest()->take(8);
            }
        ])->get();
        return view('frontend.home', compact('categories','brands'));
    }
	
	public function getCart_Add($slug = '')
    {
		//add Product
		$products = Product::where('slug',$slug)->first();
		
		Cart::add([
			'id' =>  $products->id,
			'name' => $products->name,
			'qty' => 1,
			'price' => $products->price ,
			'weight' => 0,
			'option' => [
				'sku'=> $products->sku,
				'stockquantity'=> $products->stockquantity,
				'discount'=> $products->discount,
				'averragerate'=> $products->averragerate,
				'favorites'=> $products->favorites,
				'purchases'=> $products->purchases,
				'views'=>$products->views,
				
			]
		]);
		
		
		dd(Cart::content());
        // Bổ sung code tại đây
        //return redirect()->route('frontend.home');
    }
}
