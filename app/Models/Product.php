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

    public static function getOneByCode($code)
    {
        return static::query()->where(['code' => $code])->firstOrFail();
    }

    public static function addOne($params)
    {
        $obj = new static();
        $obj->fill($params);
        $obj->save();
    }
}
