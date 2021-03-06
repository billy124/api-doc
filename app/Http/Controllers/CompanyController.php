<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Company;

class CompanyController extends Controller {
    // exclude controllers from auth
    protected $except = [
        
    ];
    
    // auto load data
    protected $load = [
        
    ];
    
    public function __construct() {
        $this->model = new Company;
        $this->auth();
    }

}