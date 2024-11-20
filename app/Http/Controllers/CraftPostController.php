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

    /**
     * Store a new post url
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_url' => 'required|url|max:2048',
        ]);

        $request->user()->postUrls()->create($validated);

        //  Dispatch the ScrapeData queue worker

        return to_route('craft-post.index');
    }
}
