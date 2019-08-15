<?php

namespace App\Models;

use App\Helpers\AssetApiHelper;
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

    protected $fillable = ['product_id', 'type', 'amount', 'part', 'hand', 'change_after', 'date'];

	const TYPE_IN  = 1; //购买
	const TYPE_OUT = 0; //赎回
	
	public static $TYPE_MAP = [
		self::TYPE_IN  => '购买',
		self::TYPE_OUT => '赎回'
	];

    public static function getListByProduct($productId)
    {
        $query = static::query()->where(['product_id' => $productId]);

        return $query->orderBy('id', 'desc')->get()->toArray();
    }
	
	/**
	 * 创建一个记录新
	 *
	 * @param $params
     * @return mixed
	 */
	public static function createOne( $params )
	{
        try {
            $product = Product::findOrFail($params['product_id']);
            $channel = Channel::findOrFail($product['group_id']);
            if ($params['part'] == 0 && $product['price']) {
                $params['part'] = round($params['amount'] / $product['price'], 4);
            }
            if ($params['hand'] == 0 && $product['type'] == AssetApiHelper::TYPE_STOCK) {
                $params['hand'] = 5 + round($params['amount'] / 10000, 2);
                if ($params['type'] == static::TYPE_OUT) {
                    $params['hand'] += round($params['amount'] * 0.001, 2);
                }
            }

            if ($params['type'] == static::TYPE_IN) {
                $channel['balance']   = $channel['balance'] - $params['amount'] - $params['hand'];
                $product['amount']    += $params['amount'];
                $product['part']      += $params['part'];
                $product['yesterday'] += $params['yesterday'] ? : $params['amount'];
            } else {
                $channel['balance']  = $channel['balance'] + $params['amount'] - $params['hand'];
                $product['amount']   -= $params['amount'];
                $product['part']     -= $params['part'];
                $product['yesterday'] -= $params['yesterday'] ? : $params['amount'];
            }
            $product['market'] = $product['part'] * $product['price'];

			$params['change_after'] = $product['amount'];
			$params['date'] = date('Y-m-d');

            unset($params['_token'], $params['yesterday']);
            $dataSer = new static();
            $dataSer->fill($params);

            DB::transaction(function () use ($channel, $dataSer, $product) {
                $channel->save();
                $dataSer->save();
                $product->save();
            });

			return $product['group_id'];
		}catch (\Throwable $ex){
			dd($ex);
		}
	}
}
