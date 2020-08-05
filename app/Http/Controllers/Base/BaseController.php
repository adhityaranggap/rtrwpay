<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    //buat index, create/edit
    protected $title = null;

    public function index()
    {
        return 'ini index '.$this->title;
    }

}
