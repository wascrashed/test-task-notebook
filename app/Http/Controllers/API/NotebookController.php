<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotebookRequest;
use App\Http\Resources\NotebookResource;
use App\Services\NotebookService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Notebook",
 *     description="API endpoints for managing notebook entries"
 * )
 */
class NotebookController extends Controller
{


    public function __construct(protected NotebookService $notebookService)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notebook",
     *     summary="Get a list of notebook entries with pagination",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of notebook entries",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NotebookResource")
     *         )
     *     )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $notes = $this->notebookService->getAllNotes($perPage);
        return NotebookResource::collection($notes);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notebook/{id}",
     *     summary="Get a notebook entry by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook entry",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notebook entry",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookResource")
     *     )
     */
    public function show($id)
    {
        $note = $this->notebookService->getNoteById($id);
        return new NotebookResource($note);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notebook",
     *     summary="Create a new notebook entry",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/NotebookRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Newly created notebook entry",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookResource")
     *     )
     */
    public function store(NotebookRequest $request)
    {
        $note = $this->notebookService->createNote($request);
        return new NotebookResource($note);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/notebook/{id}",
     *     summary="Update a notebook entry by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook entry",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/NotebookRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated notebook entry",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookResource")
     *     )
     */
    public function update(NotebookRequest $request, $id)
    {
        $note = $this->notebookService->updateNote($request, $id);
        return new NotebookResource($note);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notebook/{id}",
     *     summary="Delete a notebook entry by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook entry",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notebook entry deleted"
     *     )
     */
    public function destroy($id)
    {
        $this->notebookService->deleteNoteById($id);
        return response()->json(['message' => 'Note deleted'], 200);
    }
}
