<?php

namespace Tir\Page;


use Illuminate\Support\ServiceProvider;
use Tir\Menu\Entities\MenuItem;
use Tir\Page\Entities\Page;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/Routes/public.php');

        $this->loadRoutesFrom(__DIR__ . '/Routes/admin.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'page');

        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang/', 'page');

        $this->addDynamicRelations();


        //Add additional fields to admin crud
        $this->setAdditionalFields();

    }


    private function addDynamicRelations()
    {
        MenuItem::addDynamicRelation('page', function (MenuItem $menuItem) {
            return $menuItem->belongsTo(Page::class);
        });
    }


    private function setAdditionalFields()
    {
        $crud = resolve('Crud');

        $page = [
            'crudName' => 'menuItem',
            'fields'   => [
                'name'     => 'page_id',
                'type'     => 'relation',
                'relation' => ['page', 'name'],
                'visible'  => 'ce'
            ]
        ];
        $crud->addAdditionalFields($page);


    }


}
