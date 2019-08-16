<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\ChannelList
 * @property int $id
 * @property integer $channel_id
 * @property int $type
 * @property float $amount
 * @property float $change_after
 * @property date $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @mixin \Eloquent
 */
class ChannelList extends Model
{
    protected $table = 'channel_list';

    protected $fillable = ['group_id', 'type', 'amount', 'change_after', 'date'];
	
	const TYPE_IN  = 1; //充值
	const TYPE_OUT = 0; //取出
	
	public static $TYPE_MAP = [
		self::TYPE_IN => '充值',
		self::TYPE_OUT => '取出'
	];
	
	/**
	 * 创建一个记录新
	 *
	 * @param $params
	 */
	public static function createOne( $params )
	{
		try{
		    unset($params['_token']);

			$channel = Channel::findOrFail( $params['group_id'] );

            if ($params['type'] == static::TYPE_IN) {
                $channel['roll_in'] += $params['amount'];
                $channel['capital'] += $params['amount'];
                $channel['balance'] += $params['amount'];
            } else {
                $channel['roll_out'] += $params['amount'];
                $channel['capital']  -= $params['amount'];
                $channel['balance']  -= $params['amount'];
            }
			
			$params['change_after'] = $channel['capital'];
			$params['date'] = date('Y-m-d');

			$channelSer = new static();
			$channelSer->fill($params);
	
			DB::transaction( function () use ( $channelSer, $channel ) {
				$channelSer->save();
				$channel->save();
			} );
			
		}catch (\Throwable $ex){
			dd($ex);
		}
	}
	
}
