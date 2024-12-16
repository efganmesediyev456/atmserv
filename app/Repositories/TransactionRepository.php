<?php
namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionInterface
{
    public function getAll():Collection
    {
        return Transaction::all();
    }

    
    public  function delete(int $id):bool{
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return false;
        }
        return $transaction->delete();
    }
}
