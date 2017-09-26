<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customers
 * @package App\Models
 * @version September 26, 2017, 4:44 pm UTC
 *
 * @property string name
 * @property string location
 * @property string email
 * @property string mobile_no
 */
class Customers extends Model
{
    use SoftDeletes;

    public $table = 'customers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'location',
        'email',
        'mobile_no'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'location' => 'string',
        'email' => 'string',
        'mobile_no' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'mobile_no' => 'min:10'
    ];

    
}
