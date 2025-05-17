<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use BezhanSalleh\FilamentShield\FilamentShield;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (config('filament-shield.user.enabled', false)) {
            FilamentShield::createRole(name: config('filament-shield.user.name', 'User'));
        }

        if (config('filament-shield.admin.enabled', false)) {
            FilamentShield::createRole(name: config('filament-shield.admin.name', 'Admin'));
        }

        if (config('filament-shield.super_admin.enabled', false)) {
            FilamentShield::createRole(name: config('filament-shield.super_admin.name', 'super_admin'));
        }
        FilamentShield::createRole(name: 'Muncipality');
        FilamentShield::createRole(name: 'district');
    }
}
