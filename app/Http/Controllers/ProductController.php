<?php

namespace App\Http\Controllers;

// use App\Models\Cart;

use App\Models\CartCustom;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Products;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Products::all();
    }

    public function paginate($pageNum){



        return Products::paginate($pageNum);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);
        $product = Products::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ]);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Products::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Products::find($id);

        $product->update($request->all());

        return response()->json($product,200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);

         $product->delete();

         $text = "The product with the ID of {$id} has been deleted!";

         return response()->json($text,204);
    }
    /**
     * Search the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $product = Products::where('name', 'like', '%'.$name.'%')->get();

        $text = "The product with the Name of {$name} is not found ";

        return response()->json($product,200);
    }

    /**
     * Add a specific product to the cart of a specific User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request, $product_id){

        $user = Auth::user()->id;



            $cart = CartCustom::create([
                'product_id' => $product_id,
                'user_id' => $user,
            ]);


//        $cart = $this->updateCart();


        return response()->json([
            'message' => $cart
        ], Response::HTTP_CREATED);
    }

    public function updateCart(Request $request, $product_id, $userId=null)
    {
        $user = Auth::user()->id;

        $findCart = CartCustom::where('user_id', $user)->get('id');

        $cart = CartCustom::find($findCart);

        $cart->update([
            'product_id'=> $product_id,
            'user_id' => $user
        ]);


        return response()->json([
          'message' => $cart
        ], Response::HTTP_CREATED);
    }

    public function getIndividualCart(){

        $user = Auth::user();



        $cart = CartCustom::with(['user', 'products'])->get();

        $cart = $cart->where('user_id', $user->id);




//
        return response()->json([
            'message' => $cart
        ], Response::HTTP_ACCEPTED);
    }

    public function getAllCart()
    {
        $user = Auth::user();

        $cart = CartCustom::with(['user','products'])->get();


        return response()->json([
           'message' => $cart
        ]);
    }


}
