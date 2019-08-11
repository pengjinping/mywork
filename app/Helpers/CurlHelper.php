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
    public static function getStock($code)
    {
        $result = self::makeStockUrl($code, 1);
        if ($result == null || !isset($result['name'])) {
            $result = self::makeStockUrl($code, 2);
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
}