<?php
/**
 * 获取资产的最新净值
 */

namespace App\Helpers;

class AssetApiHelper
{
    const TYPE_STOCK      = 'stock'; // 股票
    const TYPE_FUND       = 'fund'; // 基金
    const TYPE_CURRENCY_1 = 'currency1'; // 货币基金
    const TYPE_CURRENCY_2 = 'currency2'; // 货币基金2

    public static $TYPE_MAP = [
        self::TYPE_STOCK      => '股票',
        self::TYPE_FUND       => '基金',
        self::TYPE_CURRENCY_1 => '货币基金1',
        self::TYPE_CURRENCY_2 => '货币基金2',
    ];

    /**
     * 获取资产信息内容
     *
     * @param $code
     * @param $type
     *
     * @return mixed
     */
    public static function getInfoByCode($code, $type)
    {
        if (in_array($type, self::$TYPE_MAP)) {
            $type = 'get' . ucfirst($type);

            return self::$type($code);
        }
    }

    /**
     * 获取股票信息
     *
     * @param $code
     *
     * @return mixed
     */
    public static function getStock($code)
    {
        $result = self::makeStockUrl($code, 2);
        if ($result == null || !isset($result['name'])) {
            $result = self::makeStockUrl($code, 1);
        }

        $res['name']            = $result['name'];
        $res['price']           = $result['info']['c'];
        $res['yesterday_price'] = $result['info']['yc'];

        return $res;
    }

    private static function makeStockUrl($code, $inx)
    {
        $url     = "http://pdfm.eastmoney.com/EM_UBG_PDTI_Fast/api/js?rtntype=5&cb=back&id={$code}{$inx}&type=r";
        $content = file_get_contents($url);
        $content = substr($content, 5, -1);

        return json_decode($content, true);
    }

    /**
     * 获取基金信息
     *
     * @param $code
     *
     * @return mixed
     */
    public static function getFund($code)
    {
        $url     = "http://fundgz.1234567.com.cn/js/{$code}.js";
        $content = file_get_contents($url);
        $content = substr($content, 8, -2);
        $content = json_decode($content, true);

        $res['name']            = $content['name'];
        $res['yesterday_price'] = $content['dwjz'];
        $res['price']           = $content['gsz'];

        return $res;
    }

    /**
     * 获取基金信息
     *
     * @param $code
     *
     * @return mixed
     */
    public static function getFundToday($code)
    {
        $url      = "http://hq.sinajs.cn/?list=f_{$code}";
        $content  = file_get_contents($url);
        $content  = mb_convert_encoding($content, 'UTF-8', 'GBK');
        $contents = explode('=', $content);
        $contents = explode(",", $contents[1]);

        $res['name']  = trim($contents['0'], '"');
        $res['price'] = trim($contents['1']);

        return $res;
    }

    /**
     * 获取货币基金
     * @param $code
     *
     * @return mixed
     */
    public static function getCurrency1($code = '')
    {
        $res['code']            = $code;
        $res['name']            = "货币基金";
        $res['yesterday_price'] = "1";
        $res['price']           = "1.0001";

        return $res;
    }

    /**
     * 获取快快贷信息
     * @param $code
     *
     * @return mixed
     */
    public static function getCurrency2($code = '')
    {
        $res['code']            = $code;
        $res['name']            = "快快贷";
        $res['yesterday_price'] = "1";
        $res['price']           = "1.00032";

        return $res;
    }

}