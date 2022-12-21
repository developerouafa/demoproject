<?php

namespace App\Console\Commands;

use App\Models\promotion;
use Illuminate\Console\Command;

class productexpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'product expiry promotion every end_datetime automatically';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        $admins = promotion::where('end_time', date('Y-m-d'))->get();
        foreach($admins as $admin){
            $admin->delete();
        }
    }
}
