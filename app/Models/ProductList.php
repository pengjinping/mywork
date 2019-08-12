<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\ProductList
 
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @mixin \Eloquent
 */
class ProductList extends Model
{
    protected $table = "product_list";

    protected $fillable = ['channel_id', 'code', 'type', 'amount', 'part', 'hand', 'change_after', 'date'];

	const TYPE_IN  = 1; //购买
	const TYPE_OUT = 0; //赎回
	
	public static $TYPE_MAP = [
		self::TYPE_IN  => '购买',
		self::TYPE_OUT => '赎回'
	];

    public static function getList($code, $id)
    {
        $query = static::query()->where(['code' => $code]);
        //$id && $query->where("channel_id", $id);

        return $query->orderBy('id', 'desc')->get()->toArray();
    }
	
	/**
	 * 创建一个记录新
	 *
	 * @param $params
	 */
	public static function createOne( $params )
	{
        try {

            $channel = Channel::findOrFail($params['channel_id']);
            $product = Product::getOneByCode($params['code']);

            if ($params['type'] == static::TYPE_IN) {
                $channel['balance'] = $channel['balance'] - $params['amount'] - $params['hand'];
                $product['amount']  += $params['amount'];
                $product['part']    += $params['part'];
            } else {
                $channel['balance'] = $channel['balance'] + $params['amount'] - $params['hand'];
                $product['amount']  -= $params['amount'];
                $product['part']    -= $params['part'];
            }
            $product['market'] = $product['part'] * $product['price'];

			$params['change_after'] = $product['amount'];
			$params['date'] = date('Y-m-d');

            unset($params['_token'], $params['channel_id']);
            $dataSer = new static();
            $dataSer->fill($params);

            DB::transaction(function () use ($channel, $dataSer, $product) {
                $channel->save();
                $dataSer->save();
                $product->save();
            });
			
		}catch (\Throwable $ex){
			dd($ex);
		}
	}
}
