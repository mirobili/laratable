<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface CompanyRepositoryInterface extends RepositoryInterface
{
    public function findByIrsId(string $irsId): ?Company;
}
