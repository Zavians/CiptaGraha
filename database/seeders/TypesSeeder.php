<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB ;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '123e4567-e89b-12d3-a456-426614174000', // UUID hardcode
                'name' => 'Mezzanine',
            ],
            [
                'id' => '123e4567-e89b-12d3-a456-426614174001', // UUID hardcode
                'name' => 'Galatas',
            ],
            [
                'id' => '123e4567-e89b-12d3-a456-426614174002', // UUID hardcode
                'name' => 'Mako',
            ],
            // Tambahkan lebih banyak data jika diperlukan
        ];

        // Mengisi data ke tabel
        DB::table('types')->insert($data);
    }
}
