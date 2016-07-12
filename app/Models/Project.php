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
    
    public function endpoints() {
        return $this->hasMany('App\Models\Endpoint')->withTimestamps();
    }
   
    
}