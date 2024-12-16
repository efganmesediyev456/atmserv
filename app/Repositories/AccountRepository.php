<?php
namespace App\Repositories;

use App\Interfaces\AccountRepositoryInterface;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountRepositoryInterface
{

    public function getAll(): Collection
    {
        return Account::all();
    }
    public function createOrUpdate(array $data): Account
    {
        
        $account = Account::where('user_id', $data['user_id'])->first();

        if ($account) {
            $account->balance += $data['balance'] ?? 0.00;
            $account->save();
        } else {
            $account = Account::create([
                'user_id' => $data['user_id'],
                'balance' => $data['balance'] ?? 0.00,
            ]);
        }

        return $account;
    }


    public function updateBalanceUser(int $amount): ?Account
    {
        $user    = auth('api')->user();
        $account = $user->account;
        $balance = $account->balance;
        $account->update([
            "balance" => $balance - $amount
        ]);
        return $account;
    }

    public function deleteAccount(int $id):bool{
        $account = Account::find($id);
        if (!$account) {
            return false;
        }
        return $account->delete();
    }
}
