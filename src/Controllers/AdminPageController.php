<?php

namespace Tir\Page\Controllers;

use Tir\Crud\Controllers\CrudController;
use Tir\Page\Entities\Page;

class AdminPageController extends CrudController
{
    protected $model = Page::Class;

}
