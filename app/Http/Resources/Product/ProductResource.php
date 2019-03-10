<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
		
		$this->totalPrice = $this->price * ((100 - $this->discount) / 100); 
		$this->rating = $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet'; 
		
		return [
			'name' 			=> $this->name,
			'description' 	=> $this->detail, 
			'price' 		=> $this->price,
			'stock' 		=> $this->stock,
			'discount' 		=> $this->discount,
			'totalPrice'	=> $this->totalPrice,
			'rating'		=> $this->rating,
			'href' => [
                'link' => route('reviews.index',$this->id)
            ]
		]; 
    }
}
