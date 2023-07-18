<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GenerateUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passgen {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $option = $this->option('type');

        switch ($option) {
            case 'teacher':
                $this->passGenTeacher();
                break;
            case 'student':
                $this->passGenStudent();
                return;
                break;
            default:
                $this->error('Invalid argument!');
                return;
                break;
        }
    }

    private function passGenTeacher()
    {
        $this->runGenerate(Teacher::all());
    }

    private function passGenStudent()
    {
        $this->runGenerate(Student::all());
    }

    private function runGenerate($model)
    {
        $configurations = Configuration::find(1);

        if ($configurations->is_generated === true) {
            $this->error('Sebelumnya telah melakukan generate password secara paksa. Silahkan untuk reset data user (Data Akun) terlebih dahulu untuk melakukan generate ulang.');
            return;
        }

        DB::beginTransaction();
        try {
            foreach ($model as $key => $value) {
                $user = new User;
                if ($this->option('type') === 'teacher') {
                    $user->teacher_id = $value->id;
                    $user->student_id = null;
                }
                if ($this->option('type') === 'student') {
                    $user->teacher_id = null;
                    $user->student_id = $value->id;
                }
                $user->password   = Hash::make(str_replace('/', '', date('d/m/Y', strtotime($value->date_birth))));
                $user->is_admin   = false;
                $user->is_activated = $configurations->force_activate_users;
                $user->is_password_changed = false;
                $user->is_voted   = false;
                $user->save();
                $this->line('Inserting success student id : ' . $value->id);
            }
            DB::commit();
            $this->info('Generate success.');
            $configurations->is_generated = true;
            $configurations->save();
        } catch (Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
            return;
        }
    }
}
