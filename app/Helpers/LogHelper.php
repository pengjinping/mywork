<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2019/4/2
 * Time: 上午11:14
 */

namespace App\Helpers;

class LogHelper
{
	public static $fileName;
	
	public static function setFileName( $name, $isDay = false )
	{
		if ( $isDay ) {
			$name .= '/' . date( "Y-m-d" );
		}
		
		self::$fileName = storage_path( 'logs/' . $name );
		if ( !is_dir( $dirName = dirname( self::$fileName ) ) ) {
			mkdir($dirName, 0777, true );
		}
	}
	
	public static function writeMessage( $data )
	{
		if ( !self::$fileName ) {
			self::setFileName( 'laravel' );
		}
		
		$exec = '耗时：' . round( microtime( true ) - LARAVEL_START, 3 ) . 's';
		$data = date( 'H:i:s ' ) . $exec . PHP_EOL . print_r( $data, true ) . PHP_EOL . PHP_EOL;
		file_put_contents( self::$fileName, $data, FILE_APPEND );
	}
	
	public static function writeWrong( \Exception $ex )
	{
		$data['message'] = $ex->getMessage();
		$data['file']    = $ex->getFile();
		$data['line']    = $ex->getLine();
		$data['code']    = $ex->getCode();
		
		self::writeMessage( $data );
	}
	
}