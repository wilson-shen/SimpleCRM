<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Employee;
use App\Services\CompanyService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CompanyUnitTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    public function test_get_companies(){
        Company::factory(20)->create();

        $companyService = new CompanyService();

        $companies = $companyService->getCompanies();

        $this->assertInstanceOf(Collection::class, $companies);
        $this->assertInstanceOf(Company::class, $companies->first());

        $this->assertEquals(20, $companies->count());
    }

   public function test_get_paginated_companies(){
       Company::factory(20)->create();

       $companyService = new CompanyService();

       $companies = $companyService->getPaginatedCompanies([
           'page' => 1,
           'per_page' => 10
       ]);

       $this->assertInstanceOf(LengthAwarePaginator::class, $companies);
       $this->assertInstanceOf(Company::class, $companies->items()[0]);

       $this->assertEquals(20, $companies->total());
       $this->assertEquals(2, $companies->lastPage());
       $this->assertEquals(1, $companies->currentPage());
       $this->assertEquals(10, $companies->perPage());
   }

   public function test_store_company(){
       $companyService = new CompanyService();

       $company = $companyService->storeCompany([
           'name' => 'Test Company',
           'email' => 'testcompany@example.com',
           'logo' => null,
           'website' => 'https://test.com'
       ]);

       $this->assertTrue($company->exists);
       $this->assertInstanceOf(Company::class, $company);
       $this->assertEquals('Test Company', $company->name);
       $this->assertEquals('testcompany@example.com', $company->email);
       $this->assertEquals('https://test.com', $company->website);
   }

   public function test_update_company(){
       $company = Company::factory()->create();

       $companyService = new CompanyService();

       $company = $companyService->updateCompany($company, [
           'name' => 'Test Company',
           'email' => 'testcompany@example.com',
           'logo' => null,
           'website' => 'https://test.com'
       ]);

       $this->assertTrue($company->exists);
       $this->assertInstanceOf(Company::class, $company);
       $this->assertEquals('Test Company', $company->name);
       $this->assertEquals('testcompany@example.com', $company->email);
       $this->assertEquals('https://test.com', $company->website);
   }

   public function test_delete_company(){
       $company = Company::factory()->create();

       $companyService = new CompanyService();

       $deletedCompany = $companyService->deleteCompany($company);

       $this->assertFalse($company->exists);
       $this->assertTrue($deletedCompany);
   }

   public function test_delete_company_with_employees(){
       $company = Company::factory()->create();
       Employee::factory(10)->create(['company_id' => $company->id]);

       $companyService = new CompanyService();

       $deletedCompany = $companyService->deleteCompany($company);

       $this->assertFalse($company->exists);
       $this->assertTrue($deletedCompany);

       $employees = Employee::where('company_id', $company->id)->get();

       $this->assertCount(0, $employees);
   }
}
