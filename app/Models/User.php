<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\user_country;
use App\Models\user_state;
use App\Models\user_city;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'country_code',
        'state_code',
        'city_code',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];



    static public function insert_user($validatedData){
        $validatedData['country_code'] = user_country::insert_country($validatedData);
        $validatedData['state_code'] = user_state::insert_state($validatedData);
        $validatedData['city_code'] = user_city::insert_city($validatedData);

        $user = new User();

        $user->name = $validatedData['full_name'];
        $user->email = $validatedData['email'];
        $user->mobile = $validatedData['mobile'];
        $user->country_code = $validatedData['country_code'];
        $user->state_code = $validatedData['state_code'];
        $user->city_code = $validatedData['city_code'];
        $user->avatar = $validatedData['path'];

        $user->save();

        return $user->id;
    }

    static function validate_before_input($validatedData){
        $errors = [];
        $field_arr = ['country', 'state', 'city'];
        foreach ($field_arr as $value) {
            if($validatedData[$value.'_code'] == 0){
                if(empty($validatedData[$value.'_name'])){
                    $errors['errors'][$value.'_name'] = 'This field is required';
                }
                if(preg_match('/[^a-z\s]+/', $validatedData[$value.'_name'])){
                    $errors['errors'][$value.'_name'] = 'This field require only string value';
                }
            }
        }

        return $errors;
    }

    static function get_user($id=null){
        $user = User::select("users.*", "user_countries.name as country", "user_states.name as state", "user_cities.name as city")
        ->join("user_countries", "user_countries.id", "=", "users.country_code")
        ->join("user_states", "user_states.id", "=", "users.state_code")
        ->join("user_cities", "user_cities.id", "=", "users.city_code");
        if($id){
            $user->where("users.id", $id);
        }
        return $user->get();
    }

    
}
