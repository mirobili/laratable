<?php

namespace App\Repositories\Contracts;

use App\Models\Employee;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface extends RepositoryInterface
{
    public function getEmployeesByCompany(int $companyId): Collection;
    public function findByEmail(string $email): ?Employee;
    public function searchEmployees(string $query, int $companyId): Collection;
}
