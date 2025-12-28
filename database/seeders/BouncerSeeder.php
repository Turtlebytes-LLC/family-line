<?php

namespace Database\Seeders;

use App\Models\TimelineEntry;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    public function run(): void
    {
        // Define family roles
        Bouncer::role()->firstOrCreate(['name' => 'family-member'], ['title' => 'Family Member']);
        Bouncer::role()->firstOrCreate(['name' => 'family-admin'], ['title' => 'Family Admin']);
        Bouncer::role()->firstOrCreate(['name' => 'extended-family'], ['title' => 'Extended Family (View Only)']);

        // Family members can view, create, update their family's entries
        Bouncer::allow('family-member')->to('view', TimelineEntry::class);
        Bouncer::allow('family-member')->to('create', TimelineEntry::class);
        Bouncer::allow('family-member')->to('update', TimelineEntry::class);

        // Family admins can do everything
        Bouncer::allow('family-admin')->to('view', TimelineEntry::class);
        Bouncer::allow('family-admin')->to('create', TimelineEntry::class);
        Bouncer::allow('family-admin')->to('update', TimelineEntry::class);
        Bouncer::allow('family-admin')->to('delete', TimelineEntry::class);

        // Extended family can only view
        Bouncer::allow('extended-family')->to('view', TimelineEntry::class);
    }
}
