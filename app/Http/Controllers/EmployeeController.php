<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return view('employees.index', [
            'employees' => $this->employeeService->getEmployees()
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
    public function store(Request $request)
    {
        $employee = $this->employeeService->storeEmployee($request->all());

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
    public function update(Request $request, Employee $employee)
    {
        $employee = $this->employeeService->updateEmployee($employee, $request->all());

        if($employee) {
            return redirect()->route('employees.index')->with(['success' => 'Employee updated successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update employee.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->employeeService->deleteEmployee(Employee::find($id))) {
            return redirect()->route('employees.index')->with(['success' => 'Employee deleted successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete employee.']);
    }
}
