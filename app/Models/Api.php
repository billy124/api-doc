<?php

namespace App\Models;

use App\Models\BaseModel;

class Api extends BaseModel {

    protected $table = 'apis';
    
    protected $fillable = [
        'title', 'endpoint', 'headers',
        'method', 'body', 'response', 'comments'
    ];
    
    /**
     * validation rules
     * @return array
     */
    public function rules($id = null) {
        return [
            'title' => 'required',
            'endpoint' => 'required',
            'method' => 'required'
        ];
    }
    
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }
   
    
}