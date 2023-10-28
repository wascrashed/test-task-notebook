<?php

namespace App\Services;

use App\Http\Resources\NotebookResource;
use App\Http\Requests\NotebookRequest;
use App\Models\Notebook;
use App\Models\Photo;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class NotebookService
{
    public function getAllNotes($perPage = 10)
    {
        $notes = Notebook::with('photo')->paginate($perPage);
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

        $note = Notebook::create($request);

        if ($request->hasFile('photo')) {
            $photoData = ['path' => $request->file('photo')->store('photos')];
            $photo = new Photo($photoData);
            $note->photo()->save($photo);
        }

        return $note;
    }

    public function updateNote(NotebookRequest $request, $id)
    {
        $note = $this->getNoteById($id);

        $note->update($request);

        if ($request->hasFile('photo')) {
            $photoData = ['path' => $request->file('photo')->store('photos')];
            if ($note->photo) {
                $note->photo->update($photoData);
            } else {
                $photo = new Photo($photoData);
                $note->photo()->save($photo);
            }
        }

        return $note;
    }

    public function deleteNoteById($id)
    {
        $note = $this->getNoteById($id);
        $note->delete();
    }
}
