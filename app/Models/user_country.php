<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class user_country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];



    static function insert_country($data){
        if($data['country_code'] == 0){
            $country_name = ucwords(strtolower($data['country_name']));
            $country = user_country::where('name', $country_name)->get();
            if(count($country)){
                return $country[0]['id'];
            } else {
                $country = new user_country();

                $country->name = $country_name;

                $country->save();
                return $country->id;
            }
        } else {
            return $data['country_code'];
        }
    }
}
