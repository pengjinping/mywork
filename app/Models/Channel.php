<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @mixin \Eloquent
 */
class Channel extends Model
{
    protected $table = 'channel';

    public static function getList(){
        return static::query()->get()->toArray();
    }
}
