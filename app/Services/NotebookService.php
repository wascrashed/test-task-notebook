<?php

namespace App\Services;

use App\Http\Resources\NotebookResource;
use App\Http\Requests\NotebookRequest;
use App\Models\Notebook;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class NotebookService
{
    public function getAllNotes($perPage = 10)
    {
        $notes = Notebook::paginate($perPage);
        return new LengthAwarePaginator(
            NotebookResource::collection($notes),
            $notes->total(),
            $notes->perPage(),
            $notes->currentPage()
        );
    }

    public function getNoteById($id)
    {
        return Notebook::findOrFail($id);
    }

    public function createNote(NotebookRequest $request)
    {
        $data = $request->validated();
        return Notebook::create($data);
    }

    public function updateNote(NotebookRequest $request, $id)
    {
        $data = $request->validated();
        $note = $this->getNoteById($id);
        $note->update($data);
        return $note;
    }

    public function deleteNoteById($id)
    {
        $note = $this->getNoteById($id);
        $note->delete();
    }
}
