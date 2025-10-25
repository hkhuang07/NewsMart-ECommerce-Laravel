<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\OrderTransactionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostStatusController;
use App\Http\Controllers\PostInteractionController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFavoriteController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipperAssignmentController;
use App\Http\Controllers\ShippingInformationController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\UserController;


/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

// Home and Frontend
Route::get('/', [HomeController::class, 'getHome'])->name('frontend');
Route::get('/home', [HomeController::class, 'getHome'])->name('frontend');

// Brand Management
Route::get('/brand', [BrandController::class, 'getList'])->name('brand');
Route::get('/brand/add', [BrandController::class, 'getAdd'])->name('brand.add');
Route::post('/brand/add', [BrandController::class, 'postAdd'])->name('brand.add');
Route::get('/brand/update/{id}', [BrandController::class, 'getUpdate'])->name('brand.update');
Route::post('/brand/update/{id}', [BrandController::class, 'postUpdate'])->name('brand.update');
Route::get('/brand/delete/{id}', [BrandController::class, 'getDelete'])->name('brand.delete');

//Cart Management
Route::get('/cart', [CartController::class, 'getList'])->name('cart');
Route::get('/cart/add', [CartController::class, 'getAdd'])->name('cart.add');
Route::post('/cart/add', [CartController::class, 'postAdd'])->name('cart.add');
Route::get('/cart/update/{id}', [CartController::class, 'getUpdate'])->name('cart.update');
Route::post('/cart/update/{id}', [CartController::class, 'postUpdate'])->name('cart.update');
Route::get('/cart/delete/{id}', [CartController::class, 'getDelete'])->name('cart.delete');

//Category Management
Route::get('/category', [CategoryController::class, 'getList'])->name('category');
Route::get('/category/add', [CategoryController::class, 'getAdd'])->name('category.add');
Route::post('/category/add', [CategoryController::class, 'postAdd'])->name('category.add');
Route::get('/category/update/{id}', [CategoryController::class, 'getUpdate'])->name('category.update');
Route::post('/category/update/{id}', [CategoryController::class, 'postUpdate'])->name('category.update');
Route::get('/category/delete/{id}', [CategoryController::class, 'getDelete'])->name('category.delete');

//Comment Management
Route::get('/comment', [CommentController::class, 'getList'])->name('comment');
Route::get('/comment/add', [CommentController::class, 'getAdd'])->name('comment.add');
Route::post('/comment/add', [CommentController::class, 'postAdd'])->name('comment.add');
Route::get('/comment/update/{id}', [CommentController::class, 'getUpdate'])->name('comment.update');
Route::post('/comment/update/{id}', [CommentController::class, 'postUpdate'])->name('comment.update');
Route::get('/comment/delete/{id}', [CommentController::class, 'getDelete'])->name('comment.delete');

//Configuration Management
Route::get('/configuration', [ConfigurationController::class, 'getList'])->name('configuration');
Route::get('/configuration/add', [ConfigurationController::class, 'getAdd'])->name('configuration.add');
Route::post('/configuration/add', [ConfigurationController::class, 'postAdd'])->name('configuration.add');
Route::get('/configuration/update/{key}', [ConfigurationController::class, 'getUpdate'])->name('configuration.update');
Route::post('/configuration/update/{key}', [ConfigurationController::class, 'postUpdate'])->name('configuration.update');
Route::get('/configuration/delete/{key}', [ConfigurationController::class, 'getDelete'])->name('configuration.delete');  

//Notification Management
Route::get('/notification', [NotificationController::class, 'getList'])->name('notification');
Route::get('/notification/add', [NotificationController::class, 'getAdd'])->name('notification.add');
Route::post('/notification/add', [NotificationController::class, 'postAdd'])->name('notification.add');
Route::get('/notification/update/{id}', [NotificationController::class, 'getUpdate'])->name('notification.update');
Route::post('/notification/update/{id}', [NotificationController::class, 'postUpdate'])->name('notification.update');
Route::get('/notification/delete/{id}', [NotificationController::class, 'getDelete'])->name('notification.delete');

//Order Management
Route::get('/order', [OrderController::class, 'getList'])->name('order');
Route::get('/order/add', [OrderController::class, 'getAdd'])->name('order.add');
Route::post('/order/add', [OrderController::class, 'postAdd'])->name('order.add');
Route::get('/order/update/{id}', [OrderController::class, 'getUpdate'])->name('order.update');
Route::post('/order/update/{id}', [OrderController::class, 'postUpdate'])->name('order.update');
Route::get('/order/delete/{id}', [OrderController::class, 'getDelete'])->name('order.delete');

//Order Item Management
Route::get('/orderitem', [OrderItemController::class, 'getList'])->name('orderitem');
Route::get('/orderitem/add', [OrderItemController::class, 'getAdd'])->name('orderitem.add');
Route::post('/orderitem/add', [OrderItemController::class, 'postAdd'])->name('orderitem.add');
Route::get('/orderitem/update/{id}', [OrderItemController::class, 'getUpdate'])->name('orderitem.update');
Route::post('/orderitem/update/{id}', [OrderItemController::class, 'postUpdate'])->name('orderitem.update');
Route::get('/orderitem/delete/{id}', [OrderItemController::class, 'getDelete'])->name('orderitem.delete');

//Order Status Management
Route::get('/orderstatus', [OrderStatusController::class, 'getList'])->name('orderstatus');
Route::get('/orderstatus/add', [OrderStatusController::class, 'getAdd'])->name('orderstatus.add');
Route::post('/orderstatus/add', [OrderStatusController::class, 'postAdd'])->name('orderstatus.add');
Route::get('/orderstatus/update/{id}', [OrderStatusController::class, 'getUpdate'])->name('orderstatus.update');
Route::post('/orderstatus/update/{id}', [OrderStatusController::class, 'postUpdate'])->name('orderstatus.update');
Route::get('/orderstatus/delete/{id}', [OrderStatusController::class, 'getDelete'])->name('orderstatus.delete');

//Order Transaction Management
Route::get('/ordertransaction', [OrderTransactionController::class, 'getList'])->name('ordertransaction');
Route::get('/ordertransaction/add', [OrderTransactionController::class, 'getAdd'])->name('ordertransaction.add');
Route::post('/ordertransaction/add', [OrderTransactionController::class, 'postAdd'])->name('ordertransaction.add');
Route::get('/ordertransaction/update/{id}', [OrderTransactionController::class, 'getUpdate'])->name('ordertransaction.update');
Route::post('/ordertransaction/update/{id}', [OrderTransactionController::class, 'postUpdate'])->name('ordertransaction.update');
Route::get('/ordertransaction/delete/{id}', [OrderTransactionController::class, 'getDelete'])->name('ordertransaction.delete');

//Post Management
Route::get('/post', [PostController::class, 'getList'])->name('post');
Route::get('/post/add', [PostController::class, 'getAdd'])->name('post.add');
Route::post('/post/add', [PostController::class, 'postAdd'])->name('post.add');
Route::get('/post/update/{id}', [PostController::class, 'getUpdate'])->name('post.update');     
Route::post('/post/update/{id}', [PostController::class, 'postUpdate'])->name('post.update');       
Route::get('/post/delete/{id}', [PostController::class, 'getDelete'])->name('post.delete');

//Post Status Management
Route::get('/poststatus', [PostStatusController::class, 'getList'])->name('post_status');
Route::get('/poststatus/add', [PostStatusController::class, 'getAdd'])->name('post_status.add');
Route::post('/poststatus/add', [PostStatusController::class, 'postAdd'])->name('poststatus.add');
Route::get('/poststatus/update/{id}', [PostStatusController::class, 'getUpdate'])->name('post_status.update');
Route::post('/poststatus/update/{id}', [PostStatusController::class, 'postUpdate'])->name('post_status.update');
Route::get('/poststatus/delete/{id}', [PostStatusController::class, 'getDelete'])->name('post_status.delete');

//Post Interaction Management
Route::get('/postinteraction', [PostInteractionController::class, 'getList'])->name('postinteraction');
Route::get('/postinteraction/add', [PostInteractionController::class, 'getAdd'])->name('postinteraction.add');
Route::post('/postinteraction/add', [PostInteractionController::class, 'postAdd'])->name('postinteraction.add');
Route::get('/postinteraction/update/{id}', [PostInteractionController::class, 'getUpdate'])->name('postinteraction.update');
Route::post('/postinteraction/update/{id}', [PostInteractionController::class, 'postUpdate'])->name('postinteraction.update');
Route::get('/postinteraction/delete/{id}', [PostInteractionController::class, 'getDelete'])->name('postinteraction.delete');

//Post Type Management
Route::get('/posttype', [PostTypeController::class, 'getList'])->name('post_type');
Route::get('/posttype/add', [PostTypeController::class, 'getAdd'])->name('post_type.add');
Route::post('/posttype/add', [PostTypeController::class, 'postAdd'])->name('post_type.add');
Route::get('/posttype/update/{id}', [PostTypeController::class, 'getUpdate'])->name('post_type.update');
Route::post('/posttype/update/{id}', [PostTypeController::class, 'postUpdate'])->name('post_type.update');
Route::get('/posttype/delete/{id}', [PostTypeController::class, 'getDelete'])->name('post_type.delete'); 

//Product Management
Route::get('/product', [ProductController::class, 'getList'])->name('product');
Route::get('/product/add', [ProductController::class, 'getAdd'])->name('product.add');
Route::post('/product/add', [ProductController::class, 'postAdd'])->name('product.add');
Route::get('/product/update/{id}', [ProductController::class, 'getUpdate'])->name('product.update');
Route::post('/product/update/{id}', [ProductController::class, 'postUpdate'])->name('product.update');
Route::get('/product/delete/{id}', [ProductController::class, 'getDelete'])->name('product.delete');    

//Product Favorite Management
Route::get('/productfavorite', [ProductFavoriteController::class, 'getList'])->name('productfavorite');
Route::get('/productfavorite/add', [ProductFavoriteController::class, 'getAdd'])->name('productfavorite.add');
Route::post('/productfavorite/add', [ProductFavoriteController::class, 'postAdd'])->name('productfavorite.add');
Route::get('/productfavorite/update/{id}', [ProductFavoriteController::class, 'getUpdate'])->name('productfavorite.update');
Route::post('/productfavorite/update/{id}', [ProductFavoriteController::class, 'postUpdate'])->name('productfavorite.update');
Route::get('/productfavorite/delete/{id}', [ProductFavoriteController::class, 'getDelete'])->name('productfavorite.delete');    

//Product Image Management
Route::get('/productimage', [ProductImageController::class, 'getList'])->name('productimage');
Route::get('/productimage/add', [ProductImageController::class, 'getAdd'])->name('productimage.add');
Route::post('/productimage/add', [ProductImageController::class, 'postAdd'])->name('productimage.add');
Route::get('/productimage/update/{id}', [ProductImageController::class, 'getUpdate'])->name('productimage.update');
Route::post('/productimage/update/{id}', [ProductImageController::class, 'postUpdate'])->name('productimage.update');
Route::get('/productimage/delete/{id}', [ProductImageController::class, 'getDelete'])->name('productimage.delete');

//Review Management
Route::get('/review', [ReviewController::class, 'getList'])->name('review');
Route::get('/review/add', [ReviewController::class, 'getAdd'])->name('review.add');
Route::post('/review/add', [ReviewController::class, 'postAdd'])->name('review.add');
Route::get('/review/update/{id}', [ReviewController::class, 'getUpdate'])->name('review.update');
Route::post('/review/update/{id}', [ReviewController::class, 'postUpdate'])->name('review.update');
Route::get('/review/delete/{id}', [ReviewController::class, 'getDelete'])->name('review.delete');   

//Role Management
Route::get('/role', [RoleController::class, 'getList'])->name('role');
Route::get('/role/add', [RoleController::class, 'getAdd'])->name('role.add');
Route::post('/role/add', [RoleController::class, 'postAdd'])->name('role.add');
Route::get('/role/update/{id}', [RoleController::class, 'getUpdate'])->name('role.update');
Route::post('/role/update/{id}', [RoleController::class, 'postUpdate'])->name('role.update');
Route::get('/role/delete/{id}', [RoleController::class, 'getDelete'])->name('role.delete');

//Shipper Assignment Management
Route::get('/shipperassignment', [ShipperAssignmentController::class, 'getList'])->name('shipperassignment');
Route::get('/shipperassignment/add', [ShipperAssignmentController::class, 'getAdd'])->name('shipperassignment.add');
Route::post('/shipperassignment/add', [ShipperAssignmentController::class, 'postAdd'])->name('shipperassignment.add');
Route::get('/shipperassignment/update/{id}', [ShipperAssignmentController::class, 'getUpdate'])->name('shipperassignment.update');
Route::post('/shipperassignment/update/{id}', [ShipperAssignmentController::class, 'postUpdate'])->name('shipperassignment.update');
Route::get('/shipperassignment/delete/{id}', [ShipperAssignmentController::class, 'getDelete'])->name('shipperassignment.delete');      

//Shipping Information Management
Route::get('/shippinginformation', [ShippingInformationController::class, 'getList'])->name('shippinginformation');
Route::get('/shippinginformation/add', [ShippingInformationController::class, 'getAdd'])->name('shippinginformation.add');
Route::post('/shippinginformation/add', [ShippingInformationController::class, 'postAdd'])->name('shippinginformation.add');
Route::get('/shippinginformation/update/{id}', [ShippingInformationController::class, 'getUpdate'])->name('shippinginformation.update');
Route::post('/shippinginformation/update/{id}', [ShippingInformationController::class, 'postUpdate'])->name('shippinginformation.update');
Route::get('/shippinginformation/delete/{id}', [ShippingInformationController::class, 'getDelete'])->name('shippinginformation.delete');

//Topic Management
Route::get('/topic', [TopicController::class, 'getList'])->name('topic');
Route::get('/topic/add', [TopicController::class, 'getAdd'])->name('topic.add');
Route::post('/topic/add', [TopicController::class, 'postAdd'])->name('topic.add');
Route::get('/topic/update/{id}', [TopicController::class, 'getUpdate'])->name('topic.update');
Route::post('/topic/update/{id}', [TopicController::class, 'postUpdate'])->name('topic.update');
Route::get('/topic/delete/{id}', [TopicController::class, 'getDelete'])->name('topic.delete');

//User Activity Management
Route::get('/useractivity', [UserActivityController::class, 'getList'])->name('useractivity');
Route::get('/useractivity/add', [UserActivityController::class, 'getAdd'])->name('useractivity.add');
Route::post('/useractivity/add', [UserActivityController::class, 'postAdd'])->name('useractivity.add');
Route::get('/useractivity/update/{id}', [UserActivityController::class, 'getUpdate'])->name('useractivity.update');
Route::post('/useractivity/update/{id}', [UserActivityController::class, 'postUpdate'])->name('useractivity.update');
Route::get('/useractivity/delete/{id}', [UserActivityController::class, 'getDelete'])->name('useractivity.delete');

//User Management
Route::get('/user', [UserController::class, 'getList'])->name('user');
Route::get('/user/add', [UserController::class, 'getAdd'])->name('user.add');
Route::post('/user/add', [UserController::class, 'postAdd'])->name('user.add');
Route::get('/user/update/{id}', [UserController::class, 'getUpdate'])->name('user.update');
Route::post('/user/update/{id}', [UserController::class, 'postUpdate'])->name('user.update');
Route::get('/nguoidung/xoa/{id}', [UserController::class, 'getXoa'])->name('nguoidung.xoa');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
