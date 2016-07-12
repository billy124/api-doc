<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BaseModel extends Model {

    use SoftDeletes;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    protected $hidden = [];
    protected $dates = ['deleted_at'];

    public function messages() {
        return [];
    }

    public function rules($id = null) {
        return [];
    }

}