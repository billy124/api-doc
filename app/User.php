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
        return $this->belongsToMany('App\Models\Company', 'user_company');
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
            'company_id' => 'required'
        ];
    }
    
    public function updateRules($id = null) {
        return [
            'email' => 'required|email|unique:users,email,' . $id
        ];
    }
    
    /**
     * Set the user's password with encryption.
     *
     * @param  string  $password
     */
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = \Hash::make($password);
    }
}
