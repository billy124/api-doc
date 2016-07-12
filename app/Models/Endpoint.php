<?php

namespace App\Models;

use App\Models\BaseModel;

class Endpoint extends BaseModel {

    protected $table = 'endpoints';
    
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
            'method' => 'required',
            'project_id' => 'required'
        ];
    }
    
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }
   
    
}