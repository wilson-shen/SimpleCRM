<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeIndexRequest;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService,
        protected CompanyService $companyService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeIndexRequest $request)
    {
        return view('employees.index', [
            'employees' => $this->employeeService->getPaginatedEmployees($request->validated()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.upsert', [
            'companies' => $this->companyService->getCompanies(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = $this->employeeService->storeEmployee($request->validated());

        if($employee) {
            return redirect()->route('employees.index')->with(['success' => 'Employee created successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create employee.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.upsert', [
            'employee' => $employee,
            'companies' => $this->companyService->getCompanies(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee = $this->employeeService->updateEmployee($employee, $request->validated());

        if($employee) {
            return redirect()->route('employees.index')->with(['success' => 'Employee updated successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update employee.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if($this->employeeService->deleteEmployee($employee)) {
            return redirect()->route('employees.index')->with(['success' => 'Employee deleted successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete employee.']);
    }
}
