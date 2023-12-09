<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrdersDetail;
use App\Models\OriginAddress;
use App\Services\Rajaongkir\RajaongkirService;
use Session;
use DB;
use Auth;

class ProductsController extends Controller
{
    public function listing()
    {
        $req = app()->request;
        $productsListing = Product::with('category', 'images', 'attributes');

        if ($req->filled('search')) {
            $productsListing = $productsListing->where('product_name', 'like', "%$req->search%");
        }

        $productsListing =  $productsListing->paginate($req->paginate ?? 2);
        foreach ($productsListing as $d) {
            $d->product_disc = Product::getDiscountAttributePrice($d->id);
        }

        $productsListing = json_decode(json_encode($productsListing));
        $categories = Category::where('status', 1)->get();

        return view('front.products.listing')->with(compact('productsListing', 'categories'));
    }

    public function getProduct()
    {
        $data = Product::with('category', 'images', 'attributes')->get();
        foreach ($data as $d) {
            $d->product_disc = Product::getDiscountAttributePrice($d['id']);
        }
        return response(['message' => 'Get product berhasil', 'data' => $data]);
    }

    public function detail($id)
    {
        $productDetails = Product::with('category', 'images', 'attributes')->find($id)->toArray();
        $getProductStock = Product::where('id', $id)->sum('stock');

        $reviews = Review::with('user')->where('status', 1)->where('product_id', $id)->get()->toArray();

        //Get average rating of product
        $ratingsSum = Review::where('status', 1)->where('product_id', $id)->sum('rating');
        $ratingsCount = Review::where('status', 1)->where('product_id', $id)->count();

        if ($ratingsCount > 0) {
            $avgRating = round($ratingsSum / $ratingsCount, 2);
            $avgStarRating = round($ratingsSum / $ratingsCount);
        } else {
            $avgRating = 0;
            $avgStarRating = 0;
        }

        return view('front.products.detail')->with(compact('productDetails', 'getProductStock', 'reviews', 'avgRating', 'avgStarRating'));
    }

    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
        }

        $product_att = \DB::table('products_attributes')->where('id', $data['att_id'])->first();
        $size = @$product_att->size ?? 0;
        $weight = @$product_att->weight ?? 0;

        // Check Product Stock is available or not
        $getProductStock = Product::getProductStock($data['product_id'], @$product_att->size ?? 0);
        if ($getProductStock < $data['quantity']) {
            return redirect()->back()->with('error_message', 'Produk tidak tersedia');
        }

        // Generate Session if not exist
        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = Session::getId();
            Session::put('session_id' . $session_id);
        }

        //Check existing product on cart
        if (Auth::check()) {
            //User was logged in
            $user_id = Auth::user()->id;
            $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $size, 'user_id' => $user_id])->count();
        } else {
            // User is not logged in
            $user_id = 0;
            $countProductss = Cart::where(['product_id' => $data['product_id'], 'size' => $size, 'session_id' => $session_id])->count();
        }

        if ($countProducts > 0) {
            return redirect()->back()->with('error_message', 'Produk sudah ada pada keranjang belanja');
        }


        // Save Products in carts table
        $item = new Cart;
        $item->session_id = $session_id;
        $item->user_id = $user_id;
        $item->product_id = $data['product_id'];
        $item->size = $size;
        $item->quantity = $data['quantity'];
        $item->weight = $weight;
        $item->save();
        return redirect()->back()->with('success_message', 'Produk berhasil ditambahkan ke keranjang. <a style="text-decoration:underline !important" href="/cart">Tampilkan Keranjang </a>');
    }

    public function cart()
    {

        $getCartItems = Cart::getCartItems();
        $getCouponItems = Coupon::getCouponItems();

        return view('front.products.cart')->with(compact('getCartItems', 'getCouponItems'));
    }

    public function cartUpdate(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            //Get Cart details
            $cartDetails = Cart::find($data['cartid']);


            // Check if product size is available
            $availableSize = ProductsAttribute::where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size'], 'status' => 1])->count();
            if ($availableSize == 0) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Ukuran produk ini tidak tersedia. Silahkan pilih ukuran lain',
                    'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems')),
                ]);
            }

            //Update the quantity
            Cart::where('id', $data['cartid'])->update(['quantity' => $data['qty']]);
            $getCartItems = Cart::getCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status' => true,
                'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function cartDelete(Request $request)
    {
        if ($request->ajax()) {
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $data = $request->all();
            Cart::where('id', $data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            return response()->json([
                'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $getCartItems = Cart::getCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if ($couponCount == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kupon ini sudah tidak valid',
                    'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems')),
                ]);
            } else {
                // Check for other coupon conditions

                // Get Coupon Details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                // Check if coupon is active
                if ($couponDetails->status == 0) {
                    $message = "Kupon yang Anda gunakan sudah tidak aktif.";
                }

                // Check if coupon is expired
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if ($expiry_date < $current_date) {
                    $message = "Kode kupon yang Anda masukkan sudah kadaluarsa.";
                }

                // Check if coupon is from selected categories 
                // Get all selected categories from coupon and convert to array
                $catArr = explode(",", $couponDetails->categories);

                // Check if any cart item not belong to coupon category
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = "Kode kupon ini tidak berlaku untuk salah satu produk yang dipilih.";
                    }
                    $attrPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                    /*echo "<pre>"; print_r($attrPrice); die;*/
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                // Check if coupon is from selected users
                // Get all selected users from coupon and convert to array
                if (isset($couponDetails->users) && !empty($couponDetails->users)) {
                    $usersArr = explode(",", $couponDetails->users);

                    if (count($usersArr)) {
                        // Get User Id's of all selected users
                        foreach ($usersArr as $key => $user) {
                            $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }

                        // Check if any cart item not belong to coupon user 
                        foreach ($getCartItems as $item) {
                            if (!in_array($item['user_id'], $usersId)) {
                                $message = "Kode kupon yang yang Anda masukkan tidak berlaku untuk Anda.";
                            }
                        }
                    }
                }

                // If error message is there
                if (isset($message)) {
                    return response()->json([
                        'status' => false,
                        'message' => $message,
                        'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    ]);
                } else {
                    // Check if Coupon Amount type is Fixed or Percentage
                    if ($couponDetails->amount_type == "Fixed") {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }

                    $grand_total = $total_amount - $couponAmount;

                    // Add Coupon Code & Amount in Session Variables
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']);

                    $message = "Kode kupon berhasil digunakan.";

                    return response()->json([
                        'status' => true,
                        'couponAmount' => $couponAmount,
                        'grand_total' => $grand_total,
                        'message' => $message,
                        'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    ]);
                }
            }
        }
    }

    public function checkout(Request $request)
    {
        $getCartItems = Cart::getCartItems();

        if (count($getCartItems) == 0) {
            $message = "Keranjang belanja Anda kosong, silahkan tambahkan produk ke keranjang";
            return redirect('cart')->with('error_message', $message);
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            DB::beginTransaction();

            // Fetch Order Total Price
            $total_price = 0;
            foreach ($getCartItems as $item) {
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
            }

            // Calculate Shipping Charges
            $shipping_charges = $request['shipping_cost'];

            $dataOrder = [
                'destination' =>  $request['city_id'] . ', ' . $request['province_id'],
                'courier' => $request['courier'],
                'shipping_cost' => $request['shipping_cost'],
                'shipping_method' => $request['shipping_method'],
                'total_weight' => $request['total_weight'],
            ];

            // Calculate Grand Total
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

            // Insert Grand Total in Session Variable
            Session::put('grand_total', $grand_total);

            // Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = Auth::user()->name;
            $order->address = Auth::user()->address;
            $order->mobile = Auth::user()->mobile;
            $order->email = Auth::user()->email;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "Menunggu Pembayaran";
            $order->grand_total = $grand_total;
            $order->shipping_charges = $request->shipping_cost;
            $order->courier = $request->courier;
            $order->destination = $request->destination;
            $order->note = @$request->note;
            $order->save();
            $order_id = DB::getPdo()->lastInsertId();

            foreach ($getCartItems as $item) {
                $cartItem = new OrdersDetail;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('product_name')->where('id', $item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_size = $item['size'];
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id']);
                $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }

            // Insert Order Id in Session variable
            Session::put('order_id', $order_id);
            \DB::table('carts')->where('user_id', auth()->user()->id)->delete();
            DB::commit();

            $orderDetails = Order::with('orders_detail')->where('id', $order_id)->first()->toArray();

            return response(['message' => "Checkout berhasil", 'redirect' => url("/user/orders/$order_id")]);
        }

        return view('front.products.checkout')->with(compact('getCartItems'));
    }

    public function payment(Request $request, $id)
    {

        $orderDetails = Order::where('id', $id)->first();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderDetails->id,
                'gross_amount' => $orderDetails->grand_total,
            ),
            'customer_details' => array(
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->mobile,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return response(['message' => 'Token pembayaran berhasil dibuat', 'data' => $snapToken]);
    }


    public function thanks()
    {
        if (Session::has('order_id')) {
            // Empty the cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        } else {
            return redirect('cart');
        }
    }

    public function wishlistAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
        }

        // Generate Session if not exist
        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = Session::getId();
            Session::put('session_id' . $session_id);
        }

        //Check existing product on Wishlist
        if (Auth::check()) {
            //User was logged in
            $user_id = Auth::user()->id;
            $countProducts = Wishlist::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => $user_id])->count();
        } else {
            // User is not logged in
            $user_id = 0;
            $countProducts = Wishlist::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => $session_id])->count();
        }
        if ($countProducts > 0) {

            return redirect()->back()->with('error_message', 'Produk sudah ada pada wishlist');
        }

        // Save Products in wishlist table
        $item = new Wishlist;
        $item->session_id = $session_id;
        $item->user_id = $user_id;
        $item->product_id = $data['product_id'];
        $item->size = $data['size'];
        $item->weight = $data['weight'];
        $item->save();
        return redirect()->back()->with('success_message', 'Produk berhasil ditambahkan ke wishlist. <a style="text-decoration:underline !important" href="/wishlist">Tampilkan wishlist </a>');
    }

    public function wishlist()
    {
        $getWishlistItems = Wishlist::getWishlistItems();

        return view('front.products.wishlist')->with(compact('getWishlistItems'));
    }

    public function wishlistDelete(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Wishlist::where('id', $data['wishlistid'])->delete();
            $getWishlistItems = Wishlist::getWishlistItems();
            return response()->json([
                'view' => (string)View::make('front.products.wishlist_items')->with(compact('getWishlistItems'))
            ]);
        }
    }
}
