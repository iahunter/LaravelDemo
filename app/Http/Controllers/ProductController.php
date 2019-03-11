<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser; 
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection; 
use App\Http\Resources\Product\ProductResource; 
use App\Model\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; 
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	
	public function __construct()
	{
		//Require Authentication for all APIs except index and show 
		$this->middleware('auth:api')->except('index','show');
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Return all Products via the Collection	
		//return ProductCollection::collection(Product::all());
		
		// Return Paginated Products via the Collection - ProductCollection is an extension of Resource, not ResourceCollection (default)
		$products = Product::paginate(10); 
		return ProductCollection::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
		//return Auth::id(); 
		if(Auth::id()){
			$user = Auth::id();
		}
        // Create new Product
		$product = new Product; 
		$product->name = $request->name;
		$product->detail = $request->description;
		$product->stock = $request->stock;
		$product->price = $request->price;
		$product->discount = $request->discount;
		$product->user_id = $user; 

		// Save to DB
		$product->save();

		// Get the new product and return it in the response. 
		return response([
			'request' => $request->all(), 
			'data'	=> new ProductResource($product), 
			'message' => "",
			'errors' => "",
		//], 201); 
		], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
		// Get specific Product without custom API resource
		//return $product; 
		
        // Get specific Product by ID using custom API resource
		return new ProductResource($product); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

		//
		// Check if product belongs to user. 
		$this->ProductUserCheck($product); 
        return $request; 
		// Change description to detail for our DB. 
		$request['detail'] = $request->description; 
		unset($request['description']); // Discard description since it is no longer needed. 
		
		// Update Product
		$product->update($request->all()); 
		
		// Get the new product and return it in the response. 
		return response([
			'request' => $request->all(), 
			'data'	=> new ProductResource($product), 
			'message' => "",
			'errors' => "",
		//], 201); 
		], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
		// Check if product belongs to user. 
		$this->ProductUserCheck($product); 
		
        //return $product; 
		$deleted = $product; 
		$product->delete(); 
		
		return response(null,Response::HTTP_NO_CONTENT);
		
		/* Testing Response with Deleted Product info. 
		return response([
			'request' => [], 
			'data'	=> [], 
			'message' => ["deleted" => $deleted],
			'errors' => "",
		//], 201); 
		], Response::HTTP_OK);
		*/
		
    }
	
	public function ProductUserCheck($product)
    {
		// Check if product belongs to current user. 
		if(Auth::id() !== $product->user_id){
			throw new ProductNotBelongsToUser; 
		}
    }
}
