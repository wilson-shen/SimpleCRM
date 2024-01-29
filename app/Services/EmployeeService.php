<?php

namespace App\Services;

use App\Models\Employee;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class EmployeeService
{
    /**
     * Retrieve all employees.
     *
     * @param array $request
     * @return LengthAwarePaginator
     */
    public function getEmployees(array $request): LengthAwarePaginator
    {
        return Employee::paginate(
            page: $request['page'] ?? 1,
            perPage: $request['per_page'] ?? 10
        );
    }

    /**
     * Store a new employee.
     *
     * @param array $request
     * @return Employee|null
     */
    public function storeEmployee(array $request): ?Employee
    {
        try{
            return Employee::create($request);
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }

    /**
     * Update an existing employee.
     *
     * @param Employee $employee
     * @param array $request
     * @return Employee|false
     */
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

    /**
     * Delete an existing employee.
     *
     * @param Employee $employee
     * @return bool
     */
    public function deleteEmployee(Employee $employee): bool
    {
        return $employee->delete() ?? false;
    }
}
