<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Console\Command;

class SummaryDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:day';

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
        if (in_array(date('w'), [0, 6])) {
            return false;
        }

        // 获取资产数据
        $oldDate = date("Y-m-d", strtotime("-1 day"));
        $query   = Product::query()->where('channel_id', 1);
        $query->where('part', '>', 0)->orWhere('updated_at', '>', $oldDate);
        $productData = $query->get();

        foreach ($productData as $item) {
            ProductLog::createOne($item['code'], $oldDate, $item->market);
            $item->yestoday = $item->market;
            $item->save();
        }
    }
}
