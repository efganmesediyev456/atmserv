<?php
namespace App\Interfaces;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{
    public function createOrUpdate(array $data): Account;

    public function getAll():Collection;
    
    public function deleteAccount(int $id): bool;
}
