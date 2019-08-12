<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 * @property int $id
 * @property string $channel_id
 * @property string $code
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $table = 'product';

    protected $fillable = ['channel_id', 'code', 'name', 'yprice', 'price'];

    public static function getList($id)
    {
        return static::query()->where("channel_id", $id)->get()->toArray();
    }

    public static function getOneByCode($code, $id = '')
    {
        $query = static::query()->where(['code' => $code]);
        $id && $query->where("channel_id", $id);

        return $query->firstOrFail();
    }

    public static function addOne($params)
    {
        $obj = new static();
        $obj->fill($params);
        $obj->save();
    }

    /**
     * 获取有效资产数据
     *
     * @param $channelId
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getListByChannel($channelId)
    {
        $yesterday = date("Y-m-d", strtotime("-1 day"));

        $query = Product::query()->where('channel_id', $channelId);
        $query->where(function ($q) use ($yesterday) {
            $q->where('part', '>', 0)->orWhere('updated_at', '>', $yesterday);
        });

        return $query->get();
    }
}
