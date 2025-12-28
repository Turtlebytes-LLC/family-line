<?php

namespace App\Http\Controllers;

use App\Models\TimelineEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TimelineEntryController extends Controller
{
    public function index(Request $request)
    {
        $entries = TimelineEntry::visibleTo($request->user())
            ->with('user:id,name')
            ->published()
            ->orderedByDate()
            ->paginate(20);

        return Inertia::render('Timeline/Index', [
            'entries' => $entries,
            'eventTypes' => TimelineEntry::EVENT_TYPES,
        ]);
    }

    public function create()
    {
        return Inertia::render('Timeline/Create', [
            'eventTypes' => TimelineEntry::EVENT_TYPES,
            'visibilityOptions' => TimelineEntry::VISIBILITY_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'event_type' => 'required|string|in:' . implode(',', array_keys(TimelineEntry::EVENT_TYPES)),
            'location' => 'nullable|string|max:255',
            'people_involved' => 'nullable|array',
            'people_involved.*' => 'string|max:255',
            'family_surname' => 'nullable|string|max:255',
            'visibility' => 'required|in:immediate_family,extended_family,private',
            'is_published' => 'boolean',
            'backfill_entries' => 'nullable|array',
            'backfill_entries.*.title' => 'required|string|max:255',
            'backfill_entries.*.event_type' => 'required|string|in:' . implode(',', array_keys(TimelineEntry::EVENT_TYPES)),
            'backfill_entries.*.event_date' => 'nullable|date',
            'backfill_entries.*.people_involved' => 'nullable|array',
        ]);

        // Extract backfill entries before creating main entry
        $backfillEntries = $validated['backfill_entries'] ?? [];
        unset($validated['backfill_entries']);

        $entry = TimelineEntry::create([
            'team_id' => $request->user()->currentTeam->id,
            'user_id' => $request->user()->id,
            ...$validated,
        ]);

        // Create backfill entries
        $createdBackfills = [];
        foreach ($backfillEntries as $backfill) {
            $createdBackfills[] = TimelineEntry::create([
                'team_id' => $request->user()->currentTeam->id,
                'user_id' => $request->user()->id,
                'title' => $backfill['title'],
                'event_type' => $backfill['event_type'],
                'event_date' => $backfill['event_date'] ?? null,
                'people_involved' => $backfill['people_involved'] ?? [],
                'visibility' => $validated['visibility'],
                'is_published' => $validated['is_published'],
            ]);
        }

        $message = 'Timeline entry created successfully.';
        if (count($createdBackfills) > 0) {
            $message .= ' Also created ' . count($createdBackfills) . ' related ' . (count($createdBackfills) === 1 ? 'record' : 'records') . '.';
        }

        return redirect()->route('timeline.show', $entry)
            ->with('message', $message);
    }

    public function show(TimelineEntry $entry)
    {
        Gate::authorize('view', $entry);

        $entry->load('user:id,name');

        return Inertia::render('Timeline/Show', [
            'entry' => $entry,
            'eventTypes' => TimelineEntry::EVENT_TYPES,
        ]);
    }

    public function edit(TimelineEntry $entry)
    {
        Gate::authorize('update', $entry);

        return Inertia::render('Timeline/Edit', [
            'entry' => $entry,
            'eventTypes' => TimelineEntry::EVENT_TYPES,
            'visibilityOptions' => TimelineEntry::VISIBILITY_OPTIONS,
        ]);
    }

    public function update(Request $request, TimelineEntry $entry)
    {
        Gate::authorize('update', $entry);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'event_type' => 'required|string|in:' . implode(',', array_keys(TimelineEntry::EVENT_TYPES)),
            'location' => 'nullable|string|max:255',
            'people_involved' => 'nullable|array',
            'people_involved.*' => 'string|max:255',
            'family_surname' => 'nullable|string|max:255',
            'visibility' => 'required|in:immediate_family,extended_family,private',
            'is_published' => 'boolean',
        ]);

        $entry->update($validated);

        return redirect()->route('timeline.show', $entry)
            ->with('message', 'Timeline entry updated successfully.');
    }

    public function destroy(TimelineEntry $entry)
    {
        Gate::authorize('delete', $entry);

        $entry->delete();

        return redirect()->route('timeline.index')
            ->with('message', 'Timeline entry deleted successfully.');
    }
}
