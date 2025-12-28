<?php

use App\Http\Controllers\Api\TimelineParserController;
use App\Http\Controllers\TimelineEntryController;
use App\Models\TimelineEntry;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $team = $user->currentTeam;

        $totalEntries = TimelineEntry::where('team_id', $team->id)->count();
        $thisMonth = TimelineEntry::where('team_id', $team->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $recentEntries = TimelineEntry::where('team_id', $team->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalEntries' => $totalEntries,
                'thisMonth' => $thisMonth,
                'teamMembers' => $team->allUsers()->count(),
            ],
            'recentEntries' => $recentEntries,
        ]);
    })->name('dashboard');

    Route::resource('timeline', TimelineEntryController::class)->parameters(['timeline' => 'entry']);

    // AI parsing API
    Route::post('/api/timeline/parse', [TimelineParserController::class, 'parse'])->name('api.timeline.parse');
    Route::post('/api/timeline/follow-up', [TimelineParserController::class, 'followUp'])->name('api.timeline.follow-up');
    Route::post('/api/timeline/check-backfill', [TimelineParserController::class, 'checkBackfill'])->name('api.timeline.check-backfill');
});
