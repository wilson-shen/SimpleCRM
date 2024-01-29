<?php

namespace App\Services;

use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    /**
     * Retrieve all companies.
     *
     * @return array
     */
    public function getCompanies(): array
    {
        return Company::get();
    }

    /**
     * Store a new company.
     *
     * @param array $request
     * @return Company|null
     */
    public function storeCompany(array $request): ?Company
    {
        try{
            $logoPathName = uniqid() . '.' . $request['logo']->extension();
            Storage::disk('public')->put($logoPathName, $request['logo']);

            $request = array_merge($request, ['logo' => $logoPathName]);

            return Company::create($request);
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }

    /**
     * Update an existing company.
     *
     * @param Company $company
     * @param array $request
     * @return Company|false
     */
    public function updateCompany(Company $company, array $request): Company|false
    {
        try{
            $company->update($request);
            return $company->refresh();
        } catch (Exception $e) {
            Log::error($e);
        }

        return false;
    }

    /**
     * Delete an existing company.
     *
     * @param Company $company
     * @return bool
     */
    public function deleteCompany(Company $company){
        return $company->delete() ?? false;
    }
}
