<?php

namespace App\Console\Commands;

use App\Helpers\SendWeChatHelper;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FundInvestment extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fund:investment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '基金分析';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $codeList = Cache::get('fund_investment_list');
        $dataList = Product::getFundList('');

        foreach ($dataList as $item) {
            $cha = round($item['price'] - $item['yesterday_price'], 3);
            foreach ([0.1, 0.2, 0.5] as $num) {
                abs($cha) >= $num && $this->sendLimit($codeList, $item['code'], 'value_' . $num, "{$item['name']}涨跌值已经达到{$cha}%了，请关注！");
            }

            // 涨跌幅度
            $rote = round($cha / $item['yesterday_price'], 5) * 100;
            foreach ([2, 3, 5, 7] as $num) {
                abs($rote) >= $num && $this->sendLimit($codeList, $item['code'], 'rote_' . $num, "{$item['name']}涨跌幅度已经达到{$rote}%了，请关注！");
            }

            // 参考值
            if ($item['price'] < $item['max_price'] * 0.9) {
                $this->sendLimit($codeList, $item['code'], 'max_price', "{$item['name']}回测已经达到10%了，请注意减仓！");
            }
            if ($item['price'] < $item['buy_price']) {
                $this->sendLimit($codeList, $item['code'], 'buy_price', "{$item['name']}已经跌到预计范围了，可以安排加仓啦！");
            }
            if ($item['price'] > $item['sell_price']) {
                $this->sendLimit($codeList, $item['code'], 'sell_price', "{$item['name']}已经涨到预计范围了，可以安排减仓啦！");
            }
        }

        Cache::put('fund_investment_list', $codeList, 86400);
    }

    private function sendLimit(&$codeList, $code, $key, $content) {
        $key = "{$code}_{$key}_" . date("Ymd");

        if (empty($codeList[$key])) {
            $codeList[$key] = 1;
            SendWeChatHelper::sendData($content);
        }
    }
}
