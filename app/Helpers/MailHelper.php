<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2019/4/2
 * Time: 上午11:14
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class MailHelper
{
	/**
	 * 发送纯文本邮件
	 *
	 * @param $mailName
	 * @param $title
	 * @param $text
	 */
	public static function sendText( $mailName, $title, $text )
	{
		Mail::raw( $text, function ( Message $message ) use ( $mailName, $title ) {
			$message->to( $mailName );
			$message->subject( $title );
		} );
	}
	
	/**
	 * 发送模板邮件
	 *
	 * @param $temp
	 * @param $mail
	 * @param $title
	 * @param $data
	 * @param $attachments
	 */
	public static function sendTemp($temp, $mail, $title, $data, $attachments = [])
	{
		Mail::send( 'emails.'.$temp, ['data' => $data], function ( Message $message ) use ( $mail, $title, $attachments ) {
			$message->to( $mail );
			$message->subject( $title );
			
			foreach ( $attachments as $name => $attachment ) {
				$message->attach( $attachment, ['as' => $name] );
			}
		} );
	}
	
}