<?php

namespace Tir\Page;


use Illuminate\Support\ServiceProvider;
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

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        if (! config('app.installed')) {
            return;
        }

        $this->loadRoutesFrom(__DIR__ . '/Routes/public.php');

        $this->loadRoutesFrom(__DIR__ . '/Routes/admin.php');


        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'page');

        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang/', 'page');

        // $this->addDynamicRelations();


         //Add additional fields to admin crud
         $this->setAdditionalFields();

         $this->adminMenu();

    }


    // private function addDynamicRelations()
    // {
    //     MenuItem::addDynamicRelation('page', function (MenuItem $menuItem) {
    //         return $menuItem->belongsTo(Page::class);
    //     });
    // }


    private function setAdditionalFields()
    {
        $crud = resolve('Crud');

         $page = [
             'crudName' => 'menuItem',
             'fields'   => [
                 'name'     => 'page_id',
                 'display'  => 'page',
                 'type'     => 'relation',
                 'relation' => ['page', 'name'],
                 'visible'  => 'ce'
             ]
         ];
         $crud->addAdditionalFields($page);


    }


    private function adminMenu()
    {
        $menu = resolve('AdminMenu');
        $menu->item('content')->title('page::panel.content')->link('#')->add();
        $menu->item('content.page')->title('page::panel.pages')->route('page.index')->add();

    }

}
