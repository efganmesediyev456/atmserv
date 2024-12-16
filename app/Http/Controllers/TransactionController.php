<?php
namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Interfaces\TransactionInterface;
use App\Models\BankNote;
use App\Services\AtmService;
use App\Services\AuthService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

       /**
 * @OA\Get(
 *     path="/api/transactions",
 *     summary="Get all transactions",
 *     description="List of all transactions",
 *     tags={"Transactions"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of transactions",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="username", type="string", example="John"),
 *                 @OA\Property(property="type", type="string", example="system"),
 *                 @OA\Property(property="denominations", type="string"),
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
    public function index(Request $request){
      $transactions = $this->transactionRepository->getAll();
      return TransactionResource::collection($transactions);
    }




    
    /**
     * @OA\Delete(
     *     path="/api/transactions/{id}/delete",
     *     summary="Delete an transaction",
     *     description="Deletes an transaction by its ID",
     *     tags={"Transactions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Transaction ID to be deleted",
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

     public function destroy($id)
     {
 
         $transaction = $this->transactionRepository->delete($id);
         if ($transaction) {
             return response()->json([
                 'message' => 'Transaction is deleted successfully.',
             ]);
         }
 
         return response()->json([
             'message' => 'Transaction didnt remove',
         ]);
     }
}