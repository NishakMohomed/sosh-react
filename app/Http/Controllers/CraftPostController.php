<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CraftPostController extends Controller
{
    /**
     * Display the craft post view
     */
    public function index() : Response
    {
        return Inertia::render('CraftPost');
    }
}
