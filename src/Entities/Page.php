<?php

namespace Tir\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\CrudModel;
use Tir\Crud\Support\Facades\Crud;
use Tir\Metadata\Eloquent\HasMetaData;

class Page extends CrudModel
{
    //Additional trait insert here

    use Translatable, Sluggable, HasMetaData;

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
    protected $fillable = ['name','body','slug', 'is_active'];

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
            'is_active' => 'required',
            'body' => 'required'
        ];
    }


    /**
     * This function return an object of field
     * and we use this for generate admin panel page
     * @return Object
     */
    public function getFields()
    {
        $fields = [
            [
                'name' => 'basic_information',
                'type' => 'group',
                'visible'    => 'ce',
                'tabs'=>  [
                    [
                        'name'  => 'page_information',
                        'type'  => 'tab',
                        'visible'    => 'ce',
                        'fields' => [
                            [
                                'name'       => 'id',
                                'type'       => 'text',
                                'visible'    => 'io',
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
                                'name'       => 'is_active',
                                'type'       => 'select',
                                'data'       => ['1'=>trans('menu::panel.yes'),'0'=>trans('menu::panel.no')],
                                'visible'    => 'icef',
                            ],


                        ]
                    ],
                    [
                        'name'    => 'meta',
                        'type'    => 'tab',
                        'visible' => 'ce',
                        'fields'  => [
                            [
                                'name'    => 'meta[meta_title]',
                                'display' => 'meta_title',
                                'type'    => 'text',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[meta_keywords]',
                                'display' => 'meta_keywords',
                                'type'    => 'metaKeywords',
                                'multiple' => true,
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[meta_description]',
                                'display' => 'meta_description',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[meta_custom]',
                                'display' => 'meta_custom',
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

    public function getCreatedAtAttribute($date)
    {
        return jdate($date)->ago();
    }

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
