<?php

namespace App\Console\Commands;

use App\Helpers\AssetApiHelper;
use App\Helpers\CurlHelper;
use App\Models\Channel;
use App\Models\Product;
use Illuminate\Console\Command;

class SummaryRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '监控每天数据动态变化';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dataList = Product::getFundList('');
        foreach ($dataList as $item) {
            $resData               = AssetApiHelper::getInfoByCode($item['code'], $item['type']);
            $item->market          = $resData['price'] * $item->part;
            $item->price           = $resData['price'];
            $item->yesterday_price = $resData['yesterday_price'];
            $item->yesterday       = $resData['yesterday_price'] * $item->part;
            $item->save();
        }

        Product::refreshSumByGroup();
    }

}
