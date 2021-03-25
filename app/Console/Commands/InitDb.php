<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make initial changes for users & teachers';
    private $defaultStudentEmail = 'student@example.com';
    private $defaultTeacherEmail = 'teacher@example.com';

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
        DB::table('users')
            ->where('role', 'student')
            ->limit(1)
            ->update(['email' => $this->defaultStudentEmail]);

        DB::table('users')
            ->where('role', 'teacher')
            ->limit(1)
            ->update(['email' => $this->defaultTeacherEmail]);

        DB::table('teachers')->limit(20)->update([
            'validated' => 1,
            'complete' => 1
        ]);

        return 'Success';
    }
}
