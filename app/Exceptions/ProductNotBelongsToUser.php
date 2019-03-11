<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
	// Render is auto ran. 
    public function render()
	{
		return [
				'message' => "Access Denied. Product doesn't not belong to user.", 
				'errors'	=> "Access Denied. Product doesn't not belong to user."
		]; 
	}
}
