<?php

namespace App\Console\Commands;

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getShares();
        $this->getFund(2);
        $this->getFund(3);
        $this->getFund(4);
        $this->getFund(5);
        $this->getFund(6);
        $this->getFund(7);
        $this->getFund(10);
        $this->getP2P();
    }

    /**
     * 获取股票信息
     */
    private function getShares()
    {
        $total['market']   = 0;
        $total['yestoday'] = 0;
        $productData       = Product::getListByChannel(1);
        foreach ($productData as $item) {
            $resData      = CurlHelper::getStock($item['code']);
            $item->market = $resData['price'] * $item->part;
            $item->price  = $resData['price'];
            $item->yprice = $resData['yprice'];
            $item->save();

            $total['market']   += $item->market;
            $total['yestoday'] += $item->yestoday;
        }

        Channel::where("id", 1)->update($total);
    }
	
	/**
	 * 获取基金信息
	 *
	 * @param $channelId
	 */
	private function getFund( $channelId )
	{
        $total['market']   = 0;
        $total['yestoday'] = 0;
        $productData       = Product::getListByChannel($channelId);
        foreach ($productData as $item) {
            $resData      = CurlHelper::makeJiJinUrl($item['code']);
            $item->market = $resData['price'] * $item['part'];
            $item->price  = $resData['price'];

            if ($item->yprice != $resData['yprice']) {
                $item->yprice   = $resData['yprice'];
                $item->yestoday = $resData['yprice'] * $item['part'];
            }
            $item->save();

            $total['market']   += $item->market;
            $total['yestoday'] += $item->yestoday;
        }
		
		Channel::where( "id", $channelId )->update( $total );
	}

    /**
     * 获取股票信息
     */
    private function getP2P()
    {

        $total['market']   = 0;
        $total['yestoday'] = 0;
        $productData       = Product::getListByChannel(11);
        foreach ($productData as $item) {
            $resData      = CurlHelper::kuaiKuaiDai();
            $item->market = $item->yestoday + ($resData['price'] - $resData['yprice']) * $item->part;
            $item->price  = $resData['price'];
            $item->yprice = $resData['yprice'];
            $item->save();

            $total['market']   += $item->market;
            $total['yestoday'] += $item->yestoday;
        }

        Channel::where("id", 11)->update($total);
    }
}
