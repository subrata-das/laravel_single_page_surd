<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\user_country;
use App\Models\user_state;
use App\Models\user_city;
use Illuminate\Http\Request;
// use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserFormRequest​;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = user_country::all();
        $user = User::get_user();
        return response()->view('user',['country'=>$country, 'users'=>$user]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest​ $request)
    {
        $validatedData = $request->validated();
        $res = User::validate_before_input($validatedData);
        if(!empty($res['errors'])){
            return response()->json($res);
        }
        $user = User::where('email', $validatedData['email'])->get();
        


        if(count($user)){
            $res = [
                'error' => 'Duplicate insertion occurred. Please try again with different Email !'
            ];
        } else {
            $validatedData['path'] = Storage::disk('public')->put('avatar', $validatedData['avatar']);
            $status = User::insert_user($validatedData);
            if($status){
                $data = User::get_user($status);

                $res = [
                    'success' => 'Data inserted successfully !',
                    'data'=> $data,
                    'path' => asset('storage/')
                ];
            } else {
                $res = [
                    'error' => 'Unknown error occurred. Please try again !'
                ];
            }
            
        }


        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_state($id)
    {
        $state = user_state::where('user_country_id', $id)->get();
        return response()->json($state);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_city($id)
    {
        $city = user_city::where('user_state_id', $id)->get();
        return response()->json($city);
    }
}
