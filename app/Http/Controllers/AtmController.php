<?php
namespace App\Http\Controllers;

use App\Models\BankNote;
use App\Services\AtmService;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AtmController extends Controller
{
    protected $atmService;

    public function __construct(AtmService $atmService)
    {
        $this->atmService = $atmService;
    }

    public function withdraw(Request $request){

        $amount = $request->amount;
        
        $response = $this->atmService->atmWithdraw($amount);

        return $response;
    }
}