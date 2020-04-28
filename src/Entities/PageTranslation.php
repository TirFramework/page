<?php

namespace Tir\Page\Entities;

use Tir\Crud\Support\Eloquent\TranslationModel;


class PageTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','body'];
}
