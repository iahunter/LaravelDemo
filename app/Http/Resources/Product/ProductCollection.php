<?php

namespace App\Http\Resources\Product;

// Changed from ResourceCollection to Resource
use Illuminate\Http\Resources\Json\Resource;

// Changed extends from ResourceCollection to Resource
class ProductCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        //return parent::toArray($request);
		
		// Return a custom return for each object in the collection. We do this by extending resource
		return [
			'name' => $this->name,
            'totalPrice' => round(( 1 - ($this->discount/100)) * $this->price,2),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'discount' => $this->discount,
            'href' => [
                'link' => route('products.show',$this->id)
            ]
		]; 
    }
}
