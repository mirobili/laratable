<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Collection;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAllCompanies(): Collection
    {
        return $this->companyRepository->all();
    }

    public function getCompanyById(int $id): ?Company
    {
        return $this->companyRepository->find($id);
    }

    public function createCompany(array $data): Company
    {
        return $this->companyRepository->create($data);
    }

    public function updateCompany(int $id, array $data): bool
    {
        return $this->companyRepository->update($id, $data);
    }

    public function deleteCompany(int $id): bool
    {
        return $this->companyRepository->delete($id);
    }

    public function getCompanyByIrsId(string $irsId): ?Company
    {
        return $this->companyRepository->findByIrsId($irsId);
    }
}
