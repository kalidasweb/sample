<?php

namespace App\Repositories;

use App\Models\Customers;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CustomersRepository
 * @package App\Repositories
 * @version September 26, 2017, 4:44 pm UTC
 *
 * @method Customers findWithoutFail($id, $columns = ['*'])
 * @method Customers find($id, $columns = ['*'])
 * @method Customers first($columns = ['*'])
*/
class CustomersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'location',
        'email',
        'mobile_no'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customers::class;
    }
}
