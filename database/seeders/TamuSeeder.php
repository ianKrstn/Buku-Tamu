<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tamu;

class TamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tamu::create([
        //     'name' => 'Kristian Budi Pradana Putra',
        //     'email' => 'iankrstn.kbpp@gmail.com',
        //     'timestamp' => '17:08',
        //     'comment' => 'Menarik banget sih', 
        // ]);
        
        Tamu::firstOrCreate([
            'name' => 'Kristian Budi Pradana Putra',
            'email' => 'iankrstn.kbpp@gmail.com',
            'timestamp' => '17:08',
            'comment' => 'Menarik banget sih',
        ]);
    }
}
