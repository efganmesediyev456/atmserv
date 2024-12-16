<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\BankNoteLog;
use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    public function logTransaction($amount, $status, $withdrawnNotes = [], $type = null)
    {
        if(is_null($type)){
            $type = TransactionType::SYSTEM;
        }
        $user = auth('api')->user();
        $account = $user->account;
        Transaction::create([
            'account_id' => $account->id,
            'amount' => $amount,
            'type' => $type,
            'denominations' => $status === 'success' ? json_encode($withdrawnNotes) : '',
        ]);
    }
}
