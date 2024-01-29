<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('company.index', [
            'companies' => $this->companyService->getCompanies(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = $this->companyService->storeCompany($request->all());

        if($company) {
            return redirect()->route('companies.index')->with(['success' => 'Company created successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create company.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('company.upsert', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company = $this->companyService->updateCompany($company, $request->all());

        if($company) {
            return redirect()->route('companies.index')->with(['success' => 'Company updated successfully.']);
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update company.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if($this->companyService->deleteCompany($company)) {
            return redirect()->route('companies.index')->with(['success' => 'Company deleted successfully.']);
        }

        return redirect()->back()->withErrors(['error' => 'Failed to delete company.']);
    }
}
