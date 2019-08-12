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
        $this->getGupiao();
        $this->getJiJin(2);
        $this->getJiJin(3);
        $this->getJiJin(4);
        $this->getJiJin(6);
        $this->getJiJin(7);
        $this->getKuaikuaiDai();
    }

    /**
     * 获取股票信息
     */
    private function getGupiao(){
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        // 获取资产数据
        $query = Product::query()->where('channel_id', 1);
        $query->where(function ($q) use ($yesterday) {
            $q->where('part', '>', 0)->orWhere('updated_at', '>', $yesterday);
        });
        $productData = $query->get();

        $total['market'] = 0;
        $total['yestoday'] = 0;
        foreach ($productData as $item) {
            $resData           = CurlHelper::getStock($item['code']);
            $total['market']   += $item->market;
            $total['yestoday'] += $item->yestoday;

            $item->market = $resData['price'] * $item->part;
            $item->price  = $resData['price'];
            $item->yprice = $resData['yprice'];
            $item->save();
        }

        Channel::where("id", 1)->update($total);
    }
	
	/**
	 * 获取基金信息
	 *
	 * @param $channelId
	 */
	private function getJiJin( $channelId )
	{
		$yesterday = date( "Y-m-d", strtotime( "-1 day" ) );
		// 获取资产数据
		$query = Product::query()->where( 'channel_id', $channelId );
		$query->where( function ( $q ) use ( $yesterday ) {
			$q->where( 'part', '>', 0 )->orWhere( 'updated_at', '>', $yesterday );
		} );
		$productData = $query->get();
		
		$total['market']   = 0;
		$total['yestoday'] = 0;
		foreach ( $productData as $item ) {
			$resData           = CurlHelper::makeJiJinUrl( $item['code'] );
			$total['market']   += $item->market;
			$total['yestoday'] += $item->yestoday;
			
			$item->market = $resData['price'] * $item['part'];
			$item->price  = $resData['price'];
			$item->yprice = $resData['yprice'];
			$item->save();
		}
		
		Channel::where( "id", $channelId )->update( $total );
	}
    
    /**
     * 获取股票信息
     */
    private function getKuaikuaiDai(){
        // 获取资产数据
        $query = Product::query()->where('channel_id', 11);
        $productData = $query->get();

        $total['market']   = 0;
        $total['yestoday'] = 0;
        foreach ($productData as $item) {
            $resData           = CurlHelper::kuaiKuaiDai();
            $total['market']   += $item->market;
            $total['yestoday'] += $item->yestoday;


            $item->market = $item->yestoday + ($resData['price'] - $resData['yprice']) * $item->part;
            $item->price  = $resData['price'];
            $item->yprice = $resData['yprice'];
            $item->save();
        }

        Channel::where("id", 11)->update($total);
    }
}
