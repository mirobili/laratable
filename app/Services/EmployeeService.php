<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getEmployeesByCompany(int $companyId): Collection
    {
        return $this->employeeRepository->getEmployeesByCompany($companyId);
    }

    public function getEmployee(int $id): ?Employee
    {
        return $this->employeeRepository->find($id);
    }

    public function createEmployee(array $data): Employee
    {
        // Hash the password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->employeeRepository->create($data);
    }

    public function updateEmployee(int $id, array $data): bool
    {
        // Hash the password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->employeeRepository->update($id, $data);
    }

    public function deleteEmployee(int $id): bool
    {
        // Prevent deleting the last admin
        $employee = $this->employeeRepository->find($id);
        if ($employee->is_admin) {
            $adminCount = $this->employeeRepository
                ->where('company_id', $employee->company_id)
                ->where('is_admin', true)
                ->count();
            
            if ($adminCount <= 1) {
                throw new \Exception('Cannot delete the last admin');
            }
        }

        return $this->employeeRepository->delete($id);
    }

    public function findByEmail(string $email): ?Employee
    {
        return $this->employeeRepository->findByEmail($email);
    }

    public function searchEmployees(string $query, int $companyId): Collection
    {
        return $this->employeeRepository->searchEmployees($query, $companyId);
    }

    public function verifyCredentials(string $email, string $password): ?Employee
    {
        $employee = $this->findByEmail($email);
        
        if (!$employee) {
            return null;
        }

        if (!Hash::check($password, $employee->password)) {
            return null;
        }

        return $employee;
    }
}
