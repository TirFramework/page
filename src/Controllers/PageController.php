<?php

namespace Tir\Page\Controllers;

use Tir\Page\Entities\Page;
use Illuminate\Routing\Controller;
use Tir\Setting\Facades\Stg;

class PageController extends Controller
{
    /**
     * Display page for the slug.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $logo = Stg::get('storefront_header_logo');
        $page = Page::where('slug', $slug)->firstOrFail();

        return view(config('crud.front-template').'::public.pages.show', compact('page', 'logo'));
    }
}
