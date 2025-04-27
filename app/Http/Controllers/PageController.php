<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    public function show($slug)
    {

        $page =Page::where('slug', $slug)->firstOrFail();

        return view('Ecommerce.pages.policies', compact('page'));
    }
}