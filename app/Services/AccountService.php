<?php
namespace App\Services;

use App\Interfaces\AccountRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AccountService
{
    protected $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAllAccounts(){
        return $this->accountRepository->getAll();
    }

    public function createOrUpdateAccount(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->accountRepository->createOrUpdate($data);
        });
    }

    public function deleteAccount(int $account){
        return DB::transaction(function () use ($account) {
            return $this->accountRepository->deleteAccount($account);
        });
    }
}
