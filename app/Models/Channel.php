<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel
 * @property int $id
 * @property string $name
 * @property float $capital
 * @property float $balance
 * @property float $market
 * @mixin \Eloquent
 */
class Channel extends Model
{
    public static $tableName = 'group';
    protected     $table     = 'group';
	
	public static function getList()
	{
        $dataList = static::query()->get()->toArray();
        foreach ($dataList as &$item) {
            $item['market_balance'] = round($item['balance'] + $item['market'], 2);
            $item['profit']         = round($item['market_balance'] - $item['capital'], 2);
            $item['rate']           = $item['capital'] > 0 ? round(($item['profit'] / $item['capital']) * 100, 2) : 0;
            $item['today']          = round($item['market_balance'] - $item['yesterday'], 2);
            $item['week']           = round($item['market_balance'] - $item['week'], 2);
            $item['month']          = round($item['market_balance'] - $item['month'], 2);
        }

        return $dataList;
	}
}
