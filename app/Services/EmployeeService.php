<?php

namespace App\Services;

use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\Log;

class EmployeeService
{
    public function getEmployees(): array
    {
        return Employee::get();
    }

    public function storeEmployee(array $request): ?Employee
    {
        try{
            return Employee::create($request);
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }

    public function updateEmployee(Employee $employee, array $request): Employee|false
    {
        try{
            $employee->update($request);
            return $employee->refresh();
        } catch (Exception $e) {
            Log::error($e);
        }

        return false;
    }

    public function deleteEmployee(Employee $employee): bool
    {
        return $employee->delete() ?? false;
    }
}
