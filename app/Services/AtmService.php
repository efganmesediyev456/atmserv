<?php

namespace App\Services;

use App\Models\BankNote;

class AtmService
{
    protected $bankNoteService;
    protected $transactionService;
    protected $banknotes;

    public function __construct(BankNoteService $bankNoteService, TransactionService $transactionService)
    {
        $this->bankNoteService = $bankNoteService;
        $this->transactionService = $transactionService;
        $this->banknotes = BankNote::all();

        $this->banknotes->transform(function ($item){
            return [
                'count'=>$item->count,
                'banknote'=>$item->price,
                'id'=>$item->id
            ];
        });

        $this->banknotes->sortByDesc('banknote');
    }

    public function atmWithdraw($withdraw)
    {
        // Validation
        if ($withdraw <= 0) {
            $this->transactionService->logTransaction($withdraw, 'failed');
            return $this->generateResponse(false, "Invalid Amount");
        }

        $totalAmountAvailable = $this->getTotalAvailableAmount($this->banknotes);
        if ($withdraw > $totalAmountAvailable) {
            $this->transactionService->logTransaction($withdraw, 'failed');
            return $this->generateResponse(false, "Please try a lower amount!");
        }

        // Withdraw operation
        $withdrawnNotes = $this->bankNoteService->withdrawNotes($withdraw, $this->banknotes);

        if ($withdrawnNotes) {
            $this->bankNoteService->updateBanknotes($withdrawnNotes);
            $this->bankNoteService->updateUserAccount($withdraw);
            $this->transactionService->logTransaction($withdraw, 'success', $withdrawnNotes);
            
            return $this->generateResponse(true, 'Success', $withdrawnNotes);
        } else {
            return $this->generateResponse(false, "The pull operation failed. Please try a lower amount.");
        }
    }

    private function getTotalAvailableAmount($banknotes)
    {
        return collect($banknotes)
            ->sum(function ($banknote) {
                return $banknote['count'] * $banknote['banknote'];
        });
    }

    private function generateResponse($success, $message, $data = null)
    {
        $response = ['success' => $success, 'message' => $message];
        if ($data) {
            $response['data'] = $data;
        }
        return $response;
    }
}
