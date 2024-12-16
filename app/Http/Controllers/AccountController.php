<?php
namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @OA\Get(
     *     path="/api/account",
     *     summary="Get all accounts",
     *     description="List of all accounts",
     *     tags={"Accounts"},
     *     security={{"bearerAuth":{}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="List of accounts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="balance", type="number", format="float", example=150.00),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-01T12:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-01T12:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    
    public function index(){
        $accounts =  $this->accountService->getAllAccounts();
        return AccountResource::collection($accounts);
    }

    /**
     * @OA\Post(
     *     path="/api/account/store",
     *     summary="New account create",
     *     description="New acount please add",
     *     tags={"Accounts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Account",
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="İstifadəçi ID"),
     *             @OA\Property(property="balance", type="number", format="float", example=150.00, description="Başlanğıc balans")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Account is created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Account created successfully."),
     *             @OA\Property(property="account", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="balance", type="number", format="float", example=150.00),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-01T12:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-01T12:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'balance' => 'nullable|numeric|min:0',
        ]);

        $account = $this->accountService->createOrUpdateAccount($validated);

        return response()->json([
            'message' => 'Account created successfully.',
            'account' => $account
        ], 201);
    }


    /**
 * @OA\Delete(
 *     path="/api/account/{id}/delete",
 *     summary="Delete an account",
 *     description="Deletes an account by its ID",
 *     tags={"Accounts"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Account ID to be deleted",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="True if deletion succeeded, false otherwise",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */

    public function destroy($account){

        $account = $this->accountService->deleteAccount($account);

        if( $account)
        return response()->json([
            'message' => 'Account deleted successfully.',
        ]);


        return response()->json([
            'message' => 'Account didnt delete .',
        ]);

    }
}
