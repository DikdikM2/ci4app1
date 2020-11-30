<?php

namespace App\Controllers;

class Home extends BaseController
{
	//ketika method index dipanggil maka akan menampilkan view welcome_message
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
