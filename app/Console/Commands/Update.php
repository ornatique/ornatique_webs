<?php

namespace App\Console\Commands;

use App\Models\Advertise;
use Illuminate\Console\Command;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Ad by Their End-date';

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
        Advertise::where('start_date', '<', date('Y-m-d'))->update(['active' => '1']);
        Advertise::where('start_date',  date('Y-m-d'))->update(['active' => '1']);
        Advertise::where('end_date', '<', date('Y-m-d'))->update(['active' => '0']);
        return;
    }
}