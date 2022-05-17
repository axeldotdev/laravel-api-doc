<?php

namespace Axeldotdev\LaravelApiDoc\Http\Controllers;

class ApiDocController extends Controller
{
    /**
     * Show the API doc page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('api-doc::show');
    }
}
