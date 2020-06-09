<?php

namespace Tir\Page\Controllers;



use Tir\Menu\Entities\MenuItem;

class HomeController
{
    /**
     * Display homepage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view(config('crud.front-template').'::public.home.index');
    }
}

