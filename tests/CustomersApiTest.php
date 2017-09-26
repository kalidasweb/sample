<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomersApiTest extends TestCase
{
    use MakeCustomersTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCustomers()
    {
        $customers = $this->fakeCustomersData();
        $this->json('POST', '/api/v1/customers', $customers);

        $this->assertApiResponse($customers);
    }

    /**
     * @test
     */
    public function testReadCustomers()
    {
        $customers = $this->makeCustomers();
        $this->json('GET', '/api/v1/customers/'.$customers->id);

        $this->assertApiResponse($customers->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCustomers()
    {
        $customers = $this->makeCustomers();
        $editedCustomers = $this->fakeCustomersData();

        $this->json('PUT', '/api/v1/customers/'.$customers->id, $editedCustomers);

        $this->assertApiResponse($editedCustomers);
    }

    /**
     * @test
     */
    public function testDeleteCustomers()
    {
        $customers = $this->makeCustomers();
        $this->json('DELETE', '/api/v1/customers/'.$customers->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/customers/'.$customers->id);

        $this->assertResponseStatus(404);
    }
}
