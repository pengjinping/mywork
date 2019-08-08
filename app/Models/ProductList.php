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
	
	const TYPE_IN  = 1; //购买
	const TYPE_OUT = 0; //赎回
	
	public static $TYPE_MAP = [
		self::TYPE_IN  => '购买',
		self::TYPE_OUT => '赎回'
	];
	
	public static function getList( $code )
	{
		return static::query()->where( 'code', $code )->get()->toArray();
	}
	
	/**
	 * 创建一个记录新
	 *
	 * @param $params
	 */
	public static function createOne( $params )
	{
		try{
			$product = Product::findOrFail( $params['code'] );
			
			if ( $params['type'] == static::TYPE_IN ) {
				$product->amount   += $params['amount'];
			} else {
				$product->amount  -= $params['amount'];
			}
			
			$params['change_after'] = $product->amount;
			$params['date'] = date('Y-m-d');
			
			$channelSer = new static();
			$channelSer->fill($params);
			
			DB::transaction( function () use ( $channelSer, $product ) {
				$channelSer->save();
				$product->save();
			} );
			
		}catch (\Throwable $ex){
			dd($ex);
		}
	}
}
