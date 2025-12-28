<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Document $document): bool
    {
        return $user->belongsToTeam($document->team);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Document $document): bool
    {
        return $user->belongsToTeam($document->team);
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->ownsTeam($document->team) ||
               $user->id === $document->user_id;
    }
}
