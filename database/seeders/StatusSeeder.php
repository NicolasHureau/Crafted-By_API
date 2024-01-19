<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
                'name' => 'started',
                'number' => 1,
            ],[
                'name' => 'payed',
                'number' => 2,
            ],[
                'name' => 'delivered',
                'number' => 3,
            ],
        ];
        foreach ($status as $state) {
            Status::firstOrCreate([
                'name' => $state['name'],
                'number' => $state['number'],
                ]);
        }
    }
}
