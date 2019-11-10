<?php

namespace App\Http\Controllers;

use App\Console\Commands\SummaryRunCommand;
use App\Helpers\AssetApiHelper;
use App\Models\Channel;
use App\Models\Product;

class IndexController extends Controller
{
	/**
	 * 获取投资渠道信息
	 */
    public function index()
    {
	    $dataList = Channel::getList();

        return view('index.index', ['data' => $dataList]);
    }

    /**
     * 刷新所有值
     */
    public function refresh(){
        (new SummaryRunCommand())->handle();

        return $this->index();
    }

    /**
     * 刷新基金当天值
     */
    public function refreshFund()
    {
        $dataList = Product::getFundList(AssetApiHelper::TYPE_FUND);
        foreach ($dataList as $item) {
            $resData = AssetApiHelper::getFundToday($item['code']);
            if ($resData['price'] == $item['yesterday_price']) {
                continue;
            }

            $item->market = $resData['price'] * $item->part;
            $item->price  = $resData['price'];
            $item->save();
        }

        Product::refreshSumByGroup();

        return $this->index();
    }
 
}
