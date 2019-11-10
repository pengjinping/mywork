<?php

namespace App\Http\Controllers;

use App\Helpers\AssetApiHelper;
use App\Helpers\CurlHelper;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\ProductLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $dataList = Product::getListByGroupId($id);
        foreach ($dataList as &$item) {
            $item['profit']       = round($item['market'] - $item['amount'], 2);
            $item['rate']         = $item['amount'] > 0 ? round(($item['profit'] / $item['amount']) * 100, 2) : 0;
            $item['profit_today'] = round($item['market'] - $item['yesterday'], 2);
            $item['rate_today']   = $item['yesterday'] > 0 ?
                round(($item['profit_today'] / $item['yesterday']) * 100, 2) : 0;
        }

        return view('product.index', ['data' => $dataList, 'id' => $id]);
    }

    public function add(Request $request)
    {
        $params  = $request->all();
        $resData = AssetApiHelper::getInfoByCode($params['code'], $params['type']);

        Product::firstOrCreate($params, $resData);

        return redirect('/product/' . $params['group_id']);
    }
}
