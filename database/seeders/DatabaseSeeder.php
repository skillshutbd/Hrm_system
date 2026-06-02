<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HrAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $user = User::where('email', 'admin@example.com')->first();

        if ($user) {
            $user->assignRole('Admin');
        }

        $hrAdmin = HrAdmin::where('email', 'hr@example.com')->first();

        if ($hrAdmin) {
            $hrAdmin->assignRole('hr_admin');
        }
    }
}