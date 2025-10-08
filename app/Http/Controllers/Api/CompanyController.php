<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();
        return $this->sendResponse($companies, 'Companies retrieved successfully.');
    }

    /**
     * Store a newly created company in storage.
     *
     * @param CompanyRequest $request
     * @return JsonResponse
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $company = $this->companyService->createCompany($request->validated());
        return $this->sendResponse($company, 'Company created successfully', 201);
    }

    /**
     * Display the specified company.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $company = $this->companyService->getCompanyById($id);
        
        if (!$company) {
            return $this->sendError('Company not found');
        }

        return $this->sendResponse($company, 'Company retrieved successfully');
    }

    /**
     * Update the specified company in storage.
     *
     * @param CompanyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CompanyRequest $request, int $id): JsonResponse
    {
        $updated = $this->companyService->updateCompany($id, $request->validated());
        
        if (!$updated) {
            return $this->sendError('Company not found or could not be updated');
        }

        return $this->sendResponse([], 'Company updated successfully');
    }

    /**
     * Remove the specified company from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->companyService->deleteCompany($id);
            
            if (!$deleted) {
                return $this->sendError('Company not found or could not be deleted');
            }

            return $this->sendResponse([], 'Company deleted successfully');
            
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }
}
