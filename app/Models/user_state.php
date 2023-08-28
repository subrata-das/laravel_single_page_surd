<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class user_state extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_country_id'
    ];



    static function insert_state($data){
        if($data['state_code'] == 0){
            $state_name = ucwords(strtolower($data['state_name']));
            $state = user_state::where('name', $state_name)->get();
            if(count($state)){
                return $state[0]['id'];
            } else {
                $state = new user_state();

                $state->name = $state_name;
                $state->user_country_id = $data['country_code'];

                $state->save();
                return $state->id;
            }
        } else {
            return $data['state_code'];
        }
    }
}
