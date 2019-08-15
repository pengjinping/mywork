<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel
 * @property int $id
 * @property string $name
 * @property float $go_in
 * @property float $go_out
 * @property float $capital
 * @property float $balance
 * @property float $market
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @mixin \Eloquent
 */
class Channel extends Model
{
    protected $table = 'channel';
	
	public static function getList()
	{
        $dataList = static::query()->get()->toArray();
        foreach ($dataList as &$item) {
            $item['market_balance'] = round($item['balance'] + $item['market'], 2);
            $item['profit']         = round($item['market_balance'] - $item['capital'], 2);
            $item['rate']           = $item['capital'] > 0 ? round(($item['profit'] / $item['capital']) * 100, 2) : 0;
            $item['today']          = round($item['market'] - $item['yesterday'], 2);
            $item['week']           = round($item['market'] - $item['week'], 2);
            $item['month']          = round($item['market'] - $item['month'], 2);
        }
		
		return $dataList;
	}
}
