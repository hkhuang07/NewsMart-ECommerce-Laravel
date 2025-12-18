<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
class KhachHangController extends Controller
{
    public function __construct()
	 {
	 $this->middleware('auth');
	 }

	 public function getHome()
	{
		if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            return view('frontend.home', compact('user'));
        } else
            return redirect()->route('user.register');
	}

	 public function getCheckoutPayment()
    {
        // Bổ sung code tại đây
		if (Auth::check()) {
			return view('user.checkoutpayment');
		}else 
			return redirect()->route('user.login');
    }

	 public function postCheckoutPayment(Request $request)
	 {
		$this->validate($request, [
		 'diachigiaohang' => ['required', 'string', 'max:255'],
		 'dienthoaigiaohang' => ['required', 'string', 'max:255'],
		 ]);

		 // Lưu vào đơn hàng
		 foreach(Cart::content() as $value)
		 {
			 
		 $product = Product::find($value->id);
		 if ($product) {
		 $dh = new Order();
		 $dh->userid = Auth::user()->id;
		 $dh->salerid = $product->salerid;
		 $dh->orderstatusid = 1; // Đơn hàng mới
		 $dh->totalamount = Cart::count();
		 //$dh->diachigiaohang = $request->diachigiaohang;
		 //$dh->dienthoaigiaohang = $request->dienthoaigiaohang;
		 $dh->save();
		 }
		 }
		 // Lưu vào đơn hàng chi tiết
		 foreach(Cart::content() as $value)
		 {
		 $ct = new OrderItem();
		 $ct->orderid = $dh->id;
		 $ct->productid = $value->id;
		 $ct->quantity = $value->qty;
		 $ct->priceatorder = $value->price;
		 $ct->subtotal = 0;
		 $ct->save();
		 }

		 return redirect()->route('user.checkoutthankyou');
	 }

	 public function getCheckoutThankyou()
	 {
		 Cart::destroy();
		return view('user.checkoutthankyou');

	 }

	 public function getDonHang($id = '')
	 {
	 // Bổ sung code tại đây
	 return view('user.donhang');
	 }

	 public function postDonHang(Request $request, $id)
	 {
	 // Bổ sung code tại đây
	 }

	 public function getHoSo()
	 {
	 // Bổ sung code tại đây
	 return view('user.hoso');
	 }

	 public function postHoSo(Request $request)
	 {
	 // Bổ sung code tại đây
	 return redirect()->route('user.home');
	 }

	 public function postDoiMatKhau(Request $request)
	 {
	 // Bổ sung code tại đây
	 return redirect()->route('user.home');
	 }

	 public function postDangXuat(Request $request)
	 {
	 // Bổ sung code tại đây
	 return redirect()->route('frontend.home');
	 }
}
