<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2019/4/2
 * Time: 上午11:14
 */

namespace App\Helpers;

class CurlHelper
{
    public static function getInfo($code, $channelId)
    {
        if ($code == '') {
            dd("code不可为空");
        }

        if ($channelId == 1) {
            return self::getStock($code);
        } else if($channelId == 11) {
            return self::kuaiKuaiDai();
        } else {
            return self::makeJiJinUrl($code);
        }
    }

    public static function getStock($code)
    {
        $result = self::makeStockUrl($code, 2);
        if ($result == null || !isset($result['name'])) {
            $result = self::makeStockUrl($code, 1);
        }

        $res['name']   = $result['name'];
        $res['yprice'] = $result['info']['yc'];
        $res['price']  = $result['info']['c'];

        return $res;
    }

    private static function makeStockUrl($code, $inx)
    {
        $url     = "http://pdfm.eastmoney.com/EM_UBG_PDTI_Fast/api/js?rtntype=5&cb=back&id={$code}{$inx}&type=r";
        $content = file_get_contents($url);
        $content = substr($content, 5, -1);

        return json_decode($content, true);
    }

    public static function makeJiJinUrl($code)
    {
        $url     = "http://fundgz.1234567.com.cn/js/{$code}.js";
        $content = file_get_contents($url);
        $content = substr($content, 8, -2);
        $content = json_decode($content, true);

        $res['name']   = $content['name'];
        $res['yprice'] = $content['dwjz'];
        $res['price']  = $content['gsz'];

        return $res;
    }

    public static function kuaiKuaiDai()
    {
        $res['name']   = "快快贷";
        $res['yprice'] = "1";
        $res['price']  = "1.00032";

        return $res;
    }

}