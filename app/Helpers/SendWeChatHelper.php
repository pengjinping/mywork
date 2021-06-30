<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

/**
 * 发送企业微信消息
 *
 * Class SendWeChatHelper
 *
 * @package App\Libary\Util
 */
class SendWeChatHelper {
    /**
     * 发送消息
     *
     * @param $content
     *
     * @return bool
     */
    public static function sendData($content) {
        $webHook = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=fa6b0c82-6a4d-4e6b-9258-6df1c2fd37b0';

        $value = Cache::get("send_weChat_helper_cnt", '0');
        if ($value >= 20) {
            return false;
        }
        Cache::put("send_weChat_helper_cnt", $value + 1, 1);

        $content .= "\r\n Time: " . date("Y-m-d H:i:s");
        $data['msgtype']         = 'text';
        $data['text']['content'] = $content;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $webHook);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        curl_exec($ch);
        curl_close($ch);
    }
}
