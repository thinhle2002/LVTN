<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Service\Product\ProductService;
use App\Service\Product\ProductServiceInterface;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
class CartController extends Controller
{
    private $productService;
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $carts = Cart::content();
        $total = Cart::priceTotal(0, '', '');
        $subtotal = Cart::subtotal(0, '', '');

        return view('front.shop.cart', compact('carts', 'total', 'subtotal'));
    }
    public function add(Request $request)
    {
        if($request->ajax()){
            $product = $this->productService->find($request->productId);
            
            $reponse['cart'] = Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->qty ?? 1,
                'price' => $product->discount ?? $product->price,
                'weight' => $product->weight ?? 0,
                'options' => [
                    'images' => $product->productImages,               
                    'color' => $request->color,
                    'size' => $request->size,
                ],
            ]);
            
            $reponse['count'] = Cart::count();
            $reponse['total'] = Cart::priceTotal(0, '', '') * 1000;
            
            return $reponse;
        }
        return back();
    }
    public function delete(Request $request)
    {
        if($request->ajax()){
            $reponse['cart'] = Cart::remove($request->rowId);
            $reponse['count'] = Cart::count();
            $reponse['total'] = Cart::priceTotal(0, '', '') * 1000;
            $reponse['subtotal'] = Cart::subtotal(0, '', '') * 1000;

            return $reponse;
        }
        return back();
    }
    public function destroy()
    {
        Cart::destroy();
    }
    function update (Request $request)
    {
        if($request->ajax()){
            
            Cart::update($request->rowId, $request->qty); 
            
            $item = Cart::get($request->rowId);
            $response['cart'] = [
                'rowId' => $item->rowId,
                'qty' => $item->qty,  
                'price' => $item->price, 
            
            ];
            $response['count'] = Cart::count();
            $response['total'] = Cart::priceTotal(0, '', '') * 1000;
            $response['subtotal'] = Cart::subtotal(0, '', '') * 1000;
            
            return response()->json($response);
        }
        return redirect()->back(); 
    }
}
