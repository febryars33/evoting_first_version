<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyPrograms extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            'Teknik Informatika'    =>  'Teknik Informatika',
            'Sistem Informasi'  =>  'Sistem Informasi'
        ];

        foreach ($programs as $key => $value) {
            DB::table('study_programs')->insert([
                'name'  =>  $key,
                'description'   =>  $value,
                'created_at'    =>  now()
            ]);
        }
    }
}
