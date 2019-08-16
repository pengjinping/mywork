<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2019/4/2
 * Time: 上午11:14
 */

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class DBHelper
{
	// 监听SQL执行 测试环境或者慢查询5s
	public static function listenSql()
	{
		DB::listen( function ( $query ) {
			if ( config( 'app.debug' ) || $query->time > config( 'appinit.sql_time_out' ) ) {
				LogHelper::setFileName( 'sql', true );
				
				$data['sql']    = $query->sql;
				$data['params'] = json_encode( $query->bindings, JSON_UNESCAPED_UNICODE );
				$data['time']   = $query->time;
				LogHelper::writeMessage( $data );
			}
		} );
	}

    public static function batchUpdate()
    {

    }
	
}