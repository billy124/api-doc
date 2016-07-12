<?php

namespace App\Models;

use App\Models\BaseModel;

class Company extends BaseModel {

    protected $table = 'companies';
    
    protected $fillable = [
        'name'
    ];
    
    /**
     * validation rules
     * @return array
     */
    public function rules($id = null) {
        return [
            'name' => 'required|unique:companies'
        ];
    }
    
    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
   
    
}