<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AssignUserFamilyRole
{
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Extract surname from name (last word)
        $nameParts = explode(' ', trim($user->name));
        $surname = count($nameParts) > 1 ? end($nameParts) : $nameParts[0];

        // Create a unique role name with surname + random hash
        $roleHash = Str::random(10);
        $roleName = Str::slug($surname) . '-' . $roleHash;

        // Create the role if it doesn't exist
        $role = Bouncer::role()->firstOrCreate([
            'name' => $roleName,
        ], [
            'title' => $surname . ' Family',
        ]);

        // Assign the role to the user
        Bouncer::assign($role)->to($user);

        // Also store the primary surname on the user for easy reference
        $user->update(['primary_surname' => $surname]);
    }
}
