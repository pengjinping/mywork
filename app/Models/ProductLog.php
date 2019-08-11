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
class ProductLog extends Model
{
    protected $table = "product_log";

    protected $fillable = ['code', 'date', 'market'];
    public $timestamps = false;

    public static function createOne($code, $date, $market)
    {
        $data['code'] = $code;
        $data['date'] = $date;

        static::updateOrCreate($data, ['market' => $market]);
    }
}
