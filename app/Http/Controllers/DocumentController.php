<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::forTeam($request->user()->currentTeam->id)
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return Inertia::render('Documents/Index', [
            'documents' => $documents,
        ]);
    }

    public function create()
    {
        return Inertia::render('Documents/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $document = Document::create([
            'team_id' => $request->user()->currentTeam->id,
            'user_id' => $request->user()->id,
            ...$validated,
        ]);

        return redirect()->route('documents.show', $document)
            ->with('message', 'Document created successfully.');
    }

    public function show(Document $document)
    {
        Gate::authorize('view', $document);

        $document->load('user:id,name');

        return Inertia::render('Documents/Show', [
            'document' => $document,
        ]);
    }

    public function edit(Document $document)
    {
        Gate::authorize('update', $document);

        return Inertia::render('Documents/Edit', [
            'document' => $document,
        ]);
    }

    public function update(Request $request, Document $document)
    {
        Gate::authorize('update', $document);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $document->update($validated);

        return redirect()->route('documents.show', $document)
            ->with('message', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        Gate::authorize('delete', $document);

        $document->delete();

        return redirect()->route('documents.index')
            ->with('message', 'Document deleted successfully.');
    }
}
