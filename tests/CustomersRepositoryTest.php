<?php

use App\Models\Customers;
use App\Repositories\CustomersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomersRepositoryTest extends TestCase
{
    use MakeCustomersTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomersRepository
     */
    protected $customersRepo;

    public function setUp()
    {
        parent::setUp();
        $this->customersRepo = App::make(CustomersRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCustomers()
    {
        $customers = $this->fakeCustomersData();
        $createdCustomers = $this->customersRepo->create($customers);
        $createdCustomers = $createdCustomers->toArray();
        $this->assertArrayHasKey('id', $createdCustomers);
        $this->assertNotNull($createdCustomers['id'], 'Created Customers must have id specified');
        $this->assertNotNull(Customers::find($createdCustomers['id']), 'Customers with given id must be in DB');
        $this->assertModelData($customers, $createdCustomers);
    }

    /**
     * @test read
     */
    public function testReadCustomers()
    {
        $customers = $this->makeCustomers();
        $dbCustomers = $this->customersRepo->find($customers->id);
        $dbCustomers = $dbCustomers->toArray();
        $this->assertModelData($customers->toArray(), $dbCustomers);
    }

    /**
     * @test update
     */
    public function testUpdateCustomers()
    {
        $customers = $this->makeCustomers();
        $fakeCustomers = $this->fakeCustomersData();
        $updatedCustomers = $this->customersRepo->update($fakeCustomers, $customers->id);
        $this->assertModelData($fakeCustomers, $updatedCustomers->toArray());
        $dbCustomers = $this->customersRepo->find($customers->id);
        $this->assertModelData($fakeCustomers, $dbCustomers->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCustomers()
    {
        $customers = $this->makeCustomers();
        $resp = $this->customersRepo->delete($customers->id);
        $this->assertTrue($resp);
        $this->assertNull(Customers::find($customers->id), 'Customers should not exist in DB');
    }
}
