<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class user_city extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_state_id'
    ];


    static function insert_city($data){
        if($data['city_code'] == 0){
            $city_name = ucwords(strtolower($data['city_name']));
            $city = user_city::where('name', $city_name)->get();
            if(count($city)){
                return $city[0]['id'];
            } else {
                $city = new user_city();

                $city->name = $city_name;
                $city->user_state_id = $data['state_code'];

                $city->save();
                return $city->id;
            }
        } else {
            return $data['city_code'];
        }
    }


}
