<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controllers;
use App\Http\Requests;

class itemController extends Controller
{

	public function showItem(){
		return view('item');
	}
   
}
