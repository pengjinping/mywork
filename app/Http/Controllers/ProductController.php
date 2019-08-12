<?php

namespace App\Http\Controllers;

use App\Helpers\CurlHelper;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\ProductLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function index( $id )
	{
		$dataList = Product::getList( $id );
        $total['amount'] = 0;
        $total['market'] = 0;
        $total['yesterday'] = 0;
        foreach ($dataList as &$item) {
            $total['amount']    += $item['amount'];
            $total['market']    += $item['market'];
            $total['yesterday'] += $item['yestoday'];
            $item['profit']       = round($item['market'] - $item['amount'], 2);
            $item['rate']         = $item['amount'] > 0 ? round(($item['profit'] / $item['amount']) * 100,2) : 0;
            $item['profit_today'] = round($item['market'] - $item['yestoday'], 2);
            $item['rate_today']   = $item['yestoday'] > 0 ? round(($item['profit_today'] / $item['yestoday']) * 100, 2) : 0;
        }

        $total['profit']    = round($total['market'] - $total['amount'], 2);
        $total['rate']      = $total['amount'] > 0 ? ($total['profit'] / $total['amount']) * 10000 : 0;
        $total['yesterday'] = $total['market'] - $total['yesterday'];

        return view('product.index', ['data' => $dataList, 'id' => $id, 'total' => $total]);
	}

    public function add(Request $request)
    {
        $params  = $request->all();
        $resData = CurlHelper::getInfo($params['code'], $params['channel_id']);
        $params  += $resData;

        Product::addOne($params);

        return redirect('/product/' . $params['channel_id']);
    }

	public function list(Request $request, $code )
	{
        try {
            $id = $request->input('id');
            $dataList = ProductList::getList( $code, $id);
            foreach ($dataList as &$item){
                $item['type_name'] = ProductList::$TYPE_MAP[$item['type']];
            }

            $product = Product::getOneByCode($code, $id);
        } catch (\Throwable $ex) {
            dd($ex);
        }

		return view( 'product.list', ['data' => $dataList, 'product' => $product] );
	}

    /**
     * 添加转入转出记录
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function addList(Request $request)
    {
        $params = $request->all();
        ProductList::createOne($params);

        return redirect('/product/' . $params['channel_id']);
    }
	
}
