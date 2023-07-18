<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'voting_expired'    =>  null,
            'student_score' =>  1,
            'teacher_score' =>  1,
            'force_activate_users'  =>  true
        ]);
    }
}
