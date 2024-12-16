<?php

namespace App\Services;

use App\Models\BankNote;
use App\Repositories\AccountRepository;

class BankNoteService
{

    public $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository= $accountRepository;
    }
    public function withdrawNotes($amount, $banknotes)
    {
        
        $withdrawnNotes = [];
        foreach ($banknotes as $note) {
            $count = min($note['count'], intdiv($amount, $note['banknote']));
            if ($count > 0) {
                $withdrawnNotes[] = [
                    'count' => $count,
                    'banknote' => $note['banknote'],
                    'id' => $note['id'],
                ];
                $amount -= $count * $note['banknote'];
            }
        }
        return $amount === 0 ? $withdrawnNotes : null;
    }

    public function updateBanknotes($withdrawnNotes)
    {
        foreach ($withdrawnNotes as $note) {
            $banknote = BankNote::find($note['id']);
            $banknote->count -= $note['count'];
            $banknote->save();
        }
    }


    public function updateUserAccount(int $amount){
        $this->accountRepository->updateBalanceUser($amount);
    }
}
