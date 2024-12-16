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



    /**
     * Withdraw money from ATM
     *
     * @OA\Post(
     *     path="/api/atm/withdraw",
     *     tags={"ATM"},
     *     summary="Withdraw money",
     *     description="Withdraw a specified amount from the ATM.",
     *     operationId="atmWithdraw",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="integer", example=100, description="The amount to withdraw")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Withdrawal successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Withdrawal completed"),
     *             @OA\Property(property="remaining_balance", type="integer", example=900)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Invalid amount")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred")
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdraw(Request $request){

        $this->validate($request,[
            "amount"=>"required|integer"
        ]);

        $amount = $request->amount;

        $response = $this->atmService->atmWithdraw($amount);

        return $response;
    }
}
