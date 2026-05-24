<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
 public function create(Request $request)
{
    // ئەگەر AJAX بوو → تەنها ناوەڕۆک
    if ($request->ajax()) {
        return view('welcome');
    }

    // ئەگەر refresh / direct URL بوو → layout + sidebar
    return view('welcome', [
        'page' => 'pages.register-item'
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
