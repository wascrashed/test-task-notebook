<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotebookRequest;
use App\Http\Resources\NotebookResource;
use App\Services\NotebookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Notebook",
 *     description="API endpoints for managing notebook entries"
 * )
 */

/**
 * @OA\Info(
 *     title="Notebook API",
 *     description="API endpoints for managing notebook entries",
 *     version="1.0.0"
 * )
 */
class NotebookController extends Controller
{


    /**
     * Constructor.
     */
    public function __construct(protected NotebookService $notebookService)
    {
    }

    /**
     * Get a list of notebook entries.
     *
     * @OA\Get(
     *     path="/api/notebook",
     *     summary="Get a list of notebook entries",
     *     tags={"Notebook"},
     *     @OA\Response(
     *         response=200,
     *         description="List of notebook entries",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NotebookResource")
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $notes = $this->notebookService->getAllNotes($perPage);

        return response()->json([
            'data' => NotebookResource::collection($notes),
            'message' => 'Notebooks list'
        ], 200);
    }

    /**
     * Get a specific notebook entry by ID.
     *
     * @OA\Get(
     *     path="/api/notebook/{id}",
     *     summary="Get a specific notebook entry by ID",
     *     tags={"Notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Notebook entry ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notebook entry details",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Notebook entry not found"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $note = $this->notebookService->getNoteById($id);
        if ($note) {
            return response()->json([
                'data' => new NotebookResource($note),
                'message' => 'Notebook info'
            ], 200);
        } else {
            return response()->json(['message' => 'Notebook entry not found'], 404);
        }
    }

    /**
     * Create a new notebook entry.
     *
     * @OA\Post(
     *     path="/api/notebook",
     *     summary="Create a new notebook entry",
     *     tags={"Notebook"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object", ref="#/components/schemas/NotebookRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Notebook entry created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     *
     * @param NotebookRequest $request
     * @return JsonResponse
     */
    public function store(NotebookRequest $request)
    {
        $note = $this->notebookService->createNote($request);
        return response()->json([
            'data' => new NotebookResource($note),
            'message' => 'Notebook entry created successfully'
        ], 201);
    }


    /**
     * Update an existing notebook entry.
     *
     * @OA\Put(
     *     path="/api/notebook/{id}",
     *     summary="Update an existing notebook entry",
     *     tags={"Notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Notebook entry ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/NotebookRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notebook entry updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Notebook entry not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     *
     * @param NotebookRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(NotebookRequest $request, $id)
    {
        $note = $this->notebookService->updateNote($request, $id);
        if ($note) {
            return new NotebookResource($note);
        } else {
            return response()->json(['message' => 'Notebook entry not found'], 404);
        }
    }

    /**
     * Delete a notebook entry by ID.
     *
     * @OA\Delete(
     *     path="/api/notebook/{id}",
     *     summary="Delete a notebook entry by ID",
     *     tags={"Notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Notebook entry ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notebook entry deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Notebook entry not found"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $deleted = $this->notebookService->deleteNoteById($id);
        if ($deleted) {
            return response()->json(['message' => 'Notebook entry deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Notebook entry not found'], 404);
        }
    }
}
