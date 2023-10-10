<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function company()
    {
        return view('pages.company');
    }

    public function user()
    {
        return view('pages.user');
    }

    public function category()
    {
        return view('pages.category');
    }

    public function product()
    {
        return view('pages.product');
    }

    public function order()
    {
        return view('pages.order');
    }
}
