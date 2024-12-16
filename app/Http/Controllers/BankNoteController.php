<?php
// app/Http/Controllers/BankNoteController.php

namespace App\Http\Controllers;

use App\Http\Resources\BankNoteResource;
use App\Interfaces\BankNoteRepositoryInterface;
use Illuminate\Http\Request;

class BankNoteController extends Controller
{
    protected $bankNoteRepository;

    public function __construct(BankNoteRepositoryInterface $bankNoteRepository)
    {
        $this->bankNoteRepository = $bankNoteRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/bank-notes",
     *     summary="Get all banknotes",
     *     description="List of all banknotes",
     *     tags={"Bank Notes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of banknotes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1, description="Banknote ID"),
     *                 @OA\Property(property="name", type="string", example="USD 100", description="Banknote name"),
     *                 @OA\Property(property="price", type="number", format="float", example=100.00, description="Banknote value"),
     *                 @OA\Property(property="count", type="number", format="integer", example=100),
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


    public function index()
    {
        $banknotes =  $this->bankNoteRepository->getAll();
        return BankNoteResource::collection($banknotes);
    }

    /**
     * @OA\Post(
     *     path="/api/bank-notes/store",
     *     summary="Create a new bank note",
     *     tags={"Bank Notes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"count", "price", "name"},
     *             @OA\Property(property="count", type="integer", example=10),
     *             @OA\Property(property="price", type="integer", example=100),
     *             @OA\Property(property="name", type="string", example="100 USD")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bank note created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="count", type="integer", example=10),
     *             @OA\Property(property="price", type="integer", example=100),
     *             @OA\Property(property="name", type="string", example="100 USD"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-15T10:00:00"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-15T10:00:00")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'count' => 'required|integer',
            'price' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        $bankNote = $this->bankNoteRepository->create($validated);

        return response()->json($bankNote, 201);
    }




    /**
     * @OA\Delete(
     *     path="/api/bank-notes/{id}/delete",
     *     summary="Delete an bank note",
     *     description="Deletes an bank note by its ID",
     *     tags={"Bank Notes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Bank Note ID to be deleted",
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

        $banknote = $this->bankNoteRepository->delete($id);
        if ($banknote) {
            return response()->json([
                'message' => 'Bank note is deleted successfully.',
            ]);
        }

        return response()->json([
            'message' => 'Bank note didnt remove',
        ]);
    }
}
