<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
	
	public function getRegister()
    {
        return view('user.register');
    }
    // Trang đăng nhập dành cho khách hàng
    public function getLogin()
    {
        return view('user.login');
    }
	
	public function getCart()
    {
        // Bổ sung code tại đây
        return view('frontend.cart');
    }
	
	public function getCart_Add($slug = '')
    {
		//add Product
		$products = Product::where('slug',$slug)->first();
		$products_image = ProductImage::where('productid',$products->id)->first();
		Cart::add([
			'id' =>  $products->id,
			'name' => $products->name,
			'qty' => 1,
			'price' => $products->price ,
			'weight' => 0,
			'options' => [
				'sku'=> $products->sku,
				'stockquantity'=> $products->stockquantity,
				'discount'=> $products->discount,
				'averragerate'=> $products->averragerate,
				'favorites'=> $products->favorites,
				'purchases'=> $products->purchases,
				'views'=>$products->views,
				'image'=>$products_image->url,
				
			]
		]);
		
		
		//dd(Cart::content());
        // Bổ sung code tại đây
		return redirect()->route('frontend.home');
    }
	 public function getCart_Delete($row_id)
    {
        Cart::remove($row_id);

	return redirect()->route('frontend.cart');
    }
    public function getCart_Increase($row_id)
    {
       $row = Cart::get($row_id);

		// Không được tăng vượt quá 10 sản phẩm
		if($row->qty < 20)
		{
			Cart::update($row_id, $row->qty + 1);
		}

		return redirect()->route('frontend.cart');
		
    }
    public function getCart_Decrease($row_id)
    {
        $row = Cart::get($row_id);

		 // Nếu số lượng là 1 thì không giảm được nữa
		 if($row->qty > 1)
		 {
		 Cart::update($row_id, $row->qty - 1);
		 }

		 return redirect()->route('frontend.cart');
    }
}
