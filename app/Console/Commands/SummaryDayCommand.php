<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SummaryDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:day 
                            {--date= : 统计日期}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计每天的资产情况';

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
        $channel = Channel::$tableName;
        $date    = $this->option('date') ? : date("Y-m-d");

        $week = date("w", strtotime($date));
        $day  = date("d", strtotime($date));

        // 每天更新数据[工作日]
        if (!in_array($week, [0, 6])) {
            DB::statement("update `{$channel}` set `yesterday`=`balance`+`market`");
        }

        // 每周一 刷新周统计
        $week == 1 && DB::statement("update `{$channel}` set `week`=`balance`+`market`");

        // 每月1号 刷新月统计
        $day == 1 && DB::statement("update `{$channel}` set `month`=`balance`+`market`");

    }
}
