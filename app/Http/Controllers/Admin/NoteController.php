<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::latest()->paginate(10);
        return view('admin.notes.index', compact('notes'));
    }

    public function create()
    {
        return view('admin.notes.create');
    }

    public function store(Request $request)
    {
        // Validasi 'name', bukan 'title'
        $request->validate([
            'name' => 'required|string|max:255|unique:notes,name',
        ]);

        // Simpan data (hanya name)
        Note::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.notes.index')->with('success', 'Note berhasil ditambahkan!');
    }

    public function edit(Note $note)
    {
        return view('admin.notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:notes,name,' . $note->id,
        ]);

        $note->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.notes.index')->with('success', 'Note berhasil diperbarui!');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('admin.notes.index')->with('success', 'Note berhasil dihapus!');
    }
}