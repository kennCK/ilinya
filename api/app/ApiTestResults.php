<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiTestResults extends APIModel
{   
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'api_test_results';
}
