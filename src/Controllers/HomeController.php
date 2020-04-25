<?php

namespace Tir\Page\Controllers;


class HomeController
{
    /**
     * Display homepage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('storefront::public.home.index');
    }
}

