<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class EmployeeUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_paginated_employees(){
        Company::factory(5)->create();
        Employee::factory(20)->create();

        $employeeService = new EmployeeService();

        $employees = $employeeService->getEmployees([
            'page' => 1,
            'per_page' => 10
        ]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $employees);
        $this->assertInstanceOf(Employee::class, $employees->items()[0]);

        $this->assertEquals(20, $employees->total());
        $this->assertEquals(2, $employees->lastPage());
        $this->assertEquals(1, $employees->currentPage());
        $this->assertEquals(10, $employees->perPage());
    }

    public function test_store_employee(){
        $company = Company::factory()->create();

        $employeeService = new EmployeeService();

        $employee = $employeeService->storeEmployee([
            'first_name' => 'Test',
            'last_name' => 'Employee',
            'email' => 'testemployee@example',
            'phone' => '0123456789',
            'company_id' => $company->id
        ]);

        $this->assertTrue($employee->exists);
        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertEquals('Test', $employee->first_name);
        $this->assertEquals('Employee', $employee->last_name);
        $this->assertEquals('testemployee@example', $employee->email);
        $this->assertEquals('0123456789', $employee->phone);

        $this->assertInstanceOf(Company::class, $employee->company);
        $this->assertEquals($company->id, $employee->company->id);
    }

    public function test_update_employee(){
        $company = Company::factory()->create();
        $employee = Employee::factory()->create();

        $employeeService = new EmployeeService();

        $employee = $employeeService->updateEmployee($employee, [
            'first_name' => 'Test',
            'last_name' => 'Employee',
            'email' => 'testemployee@example',
            'phone' => '0123456789',
            'company_id' => $company->id
        ]);

        $this->assertTrue($employee->exists);
        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertEquals('Test', $employee->first_name);
        $this->assertEquals('Employee', $employee->last_name);
        $this->assertEquals('testemployee@example', $employee->email);
        $this->assertEquals('0123456789', $employee->phone);

        $this->assertInstanceOf(Company::class, $employee->company);
        $this->assertEquals($company->id, $employee->company->id);
    }

    public function test_delete_employee(){
        Company::factory(5)->create();
        $employee = Employee::factory()->create();

        $employeeService = new EmployeeService();

        $employeeService->deleteEmployee($employee);

        $this->assertFalse($employee->exists);
    }
}
