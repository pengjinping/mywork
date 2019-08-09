<?php

namespace App\Console\Commands;

use App\Helpers\MailHelper;
use App\Models\Channel;
use Illuminate\Console\Command;

class SummaryWeekCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计每周的资产情况';

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
     * @return mixed
     */
    public function handle()
    {
    
    }
}