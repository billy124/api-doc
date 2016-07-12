<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function companies() {
        return $this->belongsToMany('App\Models\Company');
    }
    
    /**
     * error messages
     * @return array
     */
    public function messages() {
        return [];
    }

    /**
     * validation rules
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ];
    }
}
