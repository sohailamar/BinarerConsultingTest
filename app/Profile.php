<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    protected $fillable = ['name','email','zip','address','phone','image'];

    static function insertProfile($data,$imageName){
        $profile = new Profile;
        $profile->name = $data->name;
        $profile->address = $data->address;
        $profile->phone = $data->phone;
        $profile->email = $data->email;
        $profile->zip = $data->zip;
        $profile->image = $imageName;
        if($profile->save())
            return true;
        else
            return false;
    }
}
