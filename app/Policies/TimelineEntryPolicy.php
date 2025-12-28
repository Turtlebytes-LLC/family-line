<?php

namespace App\Policies;

use App\Models\TimelineEntry;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

class TimelineEntryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TimelineEntry $entry): bool
    {
        // Check if user belongs to the team
        if (!$user->belongsToTeam($entry->team)) {
            return false;
        }

        // Private entries only visible to creator
        if ($entry->visibility === 'private') {
            return $user->id === $entry->user_id;
        }

        // Check Bouncer abilities for surname-based access
        if ($entry->family_surname) {
            $ability = "view-family-{$entry->family_surname}";
            if (Bouncer::can($ability)) {
                return true;
            }
        }

        // Immediate and extended family visibility for team members
        return true;
    }

    public function create(User $user): bool
    {
        return $user->currentTeam !== null;
    }

    public function update(User $user, TimelineEntry $entry): bool
    {
        if (!$user->belongsToTeam($entry->team)) {
            return false;
        }

        // Owner can always update
        if ($user->id === $entry->user_id) {
            return true;
        }

        // Team owners can update any entry
        if ($user->ownsTeam($entry->team)) {
            return true;
        }

        // Check Bouncer for update ability
        return Bouncer::can('update', $entry);
    }

    public function delete(User $user, TimelineEntry $entry): bool
    {
        // Only owner or team admin can delete
        return $user->ownsTeam($entry->team) ||
               $user->id === $entry->user_id;
    }
}
