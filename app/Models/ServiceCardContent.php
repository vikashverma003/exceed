<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCardContent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_card_contents';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'card_number','created_at','updated_at','title','content'
    ];


    public function getCardAttribute(){
        if($this->card_number==1)
            return Cms::first()->service_card_1_title;
        else if($this->card_number==2)
            return Cms::first()->service_card_2_title;
        else
            return Cms::first()->service_card_3_title;
    }
}
