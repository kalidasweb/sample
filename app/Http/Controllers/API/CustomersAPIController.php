<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomersAPIRequest;
use App\Http\Requests\API\UpdateCustomersAPIRequest;
use App\Models\Customers;
use App\Repositories\CustomersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CustomersController
 * @package App\Http\Controllers\API
 */

class CustomersAPIController extends AppBaseController
{
    /** @var  CustomersRepository */
    private $customersRepository;

    public function __construct(CustomersRepository $customersRepo)
    {
        $this->customersRepository = $customersRepo;
    }

    /**
     * Display a listing of the Customers.
     * GET|HEAD /customers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->customersRepository->pushCriteria(new RequestCriteria($request));
        $this->customersRepository->pushCriteria(new LimitOffsetCriteria($request));
        $customers = $this->customersRepository->all();

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * Store a newly created Customers in storage.
     * POST /customers
     *
     * @param CreateCustomersAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomersAPIRequest $request)
    {
        $input = $request->all();

        $customers = $this->customersRepository->create($input);

        return $this->sendResponse($customers->toArray(), 'Customers saved successfully');
    }

    /**
     * Display the specified Customers.
     * GET|HEAD /customers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Customers $customers */
        $customers = $this->customersRepository->findWithoutFail($id);

        if (empty($customers)) {
            return $this->sendError('Customers not found');
        }

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * Update the specified Customers in storage.
     * PUT/PATCH /customers/{id}
     *
     * @param  int $id
     * @param UpdateCustomersAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomersAPIRequest $request)
    {
        $input = $request->all();

        /** @var Customers $customers */
        $customers = $this->customersRepository->findWithoutFail($id);

        if (empty($customers)) {
            return $this->sendError('Customers not found');
        }

        $customers = $this->customersRepository->update($input, $id);

        return $this->sendResponse($customers->toArray(), 'Customers updated successfully');
    }

    /**
     * Remove the specified Customers from storage.
     * DELETE /customers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Customers $customers */
        $customers = $this->customersRepository->findWithoutFail($id);

        if (empty($customers)) {
            return $this->sendError('Customers not found');
        }

        $customers->delete();

        return $this->sendResponse($id, 'Customers deleted successfully');
    }
}
