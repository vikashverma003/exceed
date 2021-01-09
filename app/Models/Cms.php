<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'page_heading',
		'search_placeholder',
		'search_button_title',
		'advance_search_heading',
		'advance_search_title',
		'services_title',
		'services_sub_title',
		'category_title',
		'category_sub_title',
		'manufacturer_title',
		'manufacturer_sub_title',
		'testimonial_title',
		'testimonial_sub_title',
		'created_at',
		'updated_at',
		'background_image',
		'service_card_2',
		'service_card_3',
		'service_card_1_title',
		'service_card_2_title',
		'service_card_3_title',
		'background_video'
    ];
}
