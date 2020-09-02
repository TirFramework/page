<?php

namespace Tir\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\CrudModel;
use Tir\Crud\Support\Facades\Crud;

use Config;
use File;


class Page extends CrudModel
{
    //Additional trait insert here

    use Translatable, Sluggable;

    /**
     * The attribute show route name
     * and we use in fieldTypes and controllers
     *
     * @var string
     */
    public static $routeName = 'page';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','body','slug', 'status', 'template'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'body'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    /**
     * This function return array for validation
     *
     * @return array
     */
    public function getValidation()
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'body' => 'required',
            'template' => 'required',
        ];
    }


    /**
     * This function return an object of field
     * and we use this for generate admin panel page
     * @return Object
     */
    public function getFields()
    {


        
        $path = Config::get('view.paths')[0]. '/pages';
        $templates = File::allFiles($path);
        $nameTemplate = [];
        foreach($templates as $template) {
            $value = str_replace(".blade", "", pathinfo($template, PATHINFO_FILENAME));
            $nameTemplate[$value] = trans('page::panel.'.$value);
        }


        $fields = [
            [
                'name' => 'basic_information',
                'type' => 'group',
                'visible'    => 'ce',
                'tabs'=>  [
                    [
                        'name'  => 'menu_information',
                        'type'  => 'tab',
                        'visible'    => 'ce',
                        'fields' => [
                            [
                                'name'       => 'id',
                                'type'       => 'text',
                                'visible'    => 'io',
                            ],
                            [
                                'name'       => 'page.details',
                                'type'       => 'preview',
                                'visible'    => 'e',
                            ],
                            [
                                'name'      => 'name',
                                'type'      => 'text',
                                'visible'   => 'ice',
                            ],
                            [
                                'name'      => 'slug',
                                'type'      => 'text',
                                'visible'   => 'ce',
                            ],
                            [
                                'name'      => 'body',
                                'type'      => 'textEditor',
                                'visible'   => 'ce',
                            ],
                            [
                                'name'      => 'created_at',
                                'type'      => 'text',
                                'visible'   => 'i',
                            ],
                            [
                                'name'      =>"template",
                                'type'      =>'select',
                                'data'      => $nameTemplate,
                                'visible'   =>'ce',
                            ],
                            [
                                'name'    => 'status',
                                'type'    => 'select',
                                'validation' => 'required',
                                'data'    => ['published'   => trans('post::panel.published'),
                                              'unpublished' => trans('post::panel.unpublished')
                                ],
                                'visible' => 'icef',
                            ],
                        ]
                    ],
                    [
                        'name'    => 'meta',
                        'type'    => 'tab',
                        'visible' => 'ce',
                        'fields'  => [
                            [
                                'name'    => 'meta[keyword]',
                                'display' => 'meta_keywords',
                                'type'    => 'text',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[description]',
                                'display' => 'meta_description',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                        ]
                    ]

                ]
            ]
        ];
        return $fields;}

    //Additional methods //////////////////////////////////////////////////////////////////////////////////////////////

    // public function getCreatedAtAttribute($date)
    // {
    //     return jdate($date)->ago();
    // }

    public static function urlForPage($id)
    {
        return static::select('slug')->firstOrNew(['id' => $id])->url();
    }

    public function url()
    {
        if (is_null($this->slug)) {
            return '#';
        }

        return '/page/'.$this->slug;

        //TODO:localized url check
        //return localized_url(Crud::locale(), $this->slug);
    }



    //Relations methods ///////////////////////////////////////////////////////////////////////////////////////////////



}
