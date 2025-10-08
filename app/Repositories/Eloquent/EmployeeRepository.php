<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function getEmployeesByCompany(int $companyId): Collection
    {
        return $this->model->where('company_id', $companyId)
            ->orderBy('name_last')
            ->orderBy('name_first')
            ->get();
    }

    public function findByEmail(string $email): ?Employee
    {
        return $this->model->where('email', $email)->first();
    }

    public function searchEmployees(string $query, int $companyId): Collection
    {
        return $this->model->where('company_id', $companyId)
            ->where(function($q) use ($query) {
                $q->where('name_first', 'like', "%{$query}%")
                  ->orWhere('name_last', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->orderBy('name_last')
            ->orderBy('name_first')
            ->get();
    }
}
