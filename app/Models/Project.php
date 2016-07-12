<?php

namespace App\Models;

use App\Models\BaseModel;

class Project extends BaseModel {

    protected $table = 'projects';
    
    protected $fillable = [
        'name', 'description'
    ];
    
    /**
     * validation rules
     * @return array
     */
    public function rules($id = null) {
        return [
            'name' => 'required'
        ];
    }
    
    public function apis() {
        return $this->hasMany('App\Models\Api')->withTimestamps();
    }
   
    
}