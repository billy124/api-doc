<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Project;

class ProjectController extends Controller {
    // exclude controllers from auth
    protected $except = [
        
    ];
    
    // auto load data
    protected $load = [
        
    ];
    
    public function __construct() {
        $this->model = new Project;
        $this->auth();
    }

}