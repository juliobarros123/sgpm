<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Logger;

class HomeController extends Controller
{
    //
    public function __construct()
    {

        $this->logger = new Logger();

    }
   
    public function index()
    {

       
        return view('admin.index');

    }
}
