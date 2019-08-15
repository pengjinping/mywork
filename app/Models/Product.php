<?php

namespace App\Models;

use App\Helpers\AssetApiHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    protected $fillable = ['group_id', 'code', 'name', 'type', 'amount', 'part', 'market', 'yesterday', 'price', 'yesterday_price'];

    /**
     * 按组查询资产明细
     *
     * @param $id
     *
     * @return array
     */
    public static function getListByGroupId($id)
    {
        $query = static::query();
        $id && $query->where("group_id", $id);

        return $query->get()->toArray();
    }

    /**
     * 获取有效资产数据
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getList()
    {
        $yesterday = date("Y-m-d", strtotime("-1 day"));

        return Product::query()->where('part', '>', 0)->orWhere('updated_at', '>', $yesterday)->get();
    }

    /**
     * 获取有效资产数据
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getFundList()
    {
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $query     = Product::query()->where("type", AssetApiHelper::TYPE_FUND);
        $query->where(function ($q) use ($yesterday) {
            $q->where('part', '>', 0)->orWhere('updated_at', '>', $yesterday);
        });

        return $query->get();
    }

    /**
     * 按组统计市值与昨日价格
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function refreshSumByGroup()
    {
        $query = Product::query()->groupBy("group_id");
        $query->selectRaw("sum(market) as market, sum(yesterday) as yesterday, group_id");

        $dataList = $query->get()->toArray();

        foreach ($dataList as $item) {
            $id = $item['group_id'];
            unset($item['group_id']);
            Channel::where("id", $id)->update($item);
        }
    }
}
