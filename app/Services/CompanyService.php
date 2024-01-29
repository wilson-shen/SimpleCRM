<?php

namespace App\Services;

use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    /**
     * Retrieve all companies.
     *
     * @return Collection
     */
    public function getCompanies(): Collection
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
            if(isset($request['logo'])){
                $logoName = uniqid() . '.' . $request['logo']->extension();
                Storage::disk('public')->putFileAs('', $request['logo'], $logoName);

                $request = array_merge($request, ['logo' => $logoName]);
            }

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

            if(isset($request['logo'])){
                $logoName = uniqid() . '.' . $request['logo']->extension();
                Storage::disk('public')->putFileAs('', $request['logo'], $logoName);

                $request = array_merge($request, ['logo' => $logoName]);
            }

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
    public function deleteCompany(Company $company): bool
    {
        if($company->logo){
            Storage::disk('public')->delete($company->logo);
        }

        return $company->delete() ?? false;
    }
}
