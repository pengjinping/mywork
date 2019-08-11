<?php

namespace App\Http\Controllers;

use App\Helpers\CurlHelper;
use App\Models\Product;
use App\Models\ProductList;
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
            $item['rate']         = $item['amount'] > 0 ? ($item['profit'] / $item['amount']) * 10000 : 0;
            $item['profit_today'] = $item['market'] - $item['yestoday'];
            $item['rate_today']   = $item['amount'] > 0 ? ($item['profit_today'] / $item['market']) * 10000 : 0;
        }

        $total['profit']    = round($total['market'] - $total['amount'], 2);
        $total['rate']      = $total['amount'] > 0 ? ($total['profit'] / $total['amount']) * 10000 : 0;
        $total['yesterday'] = $total['market'] - $total['yesterday'];

        return view('product.index', ['data' => $dataList, 'id' => $id, 'total' => $total]);
	}

    public function add(Request $request)
    {
        $params  = $request->all();
        $resData = CurlHelper::getStock($params['code']);
        $params  += $resData;
        Product::addOne($params);

        return redirect('/product/' . $params['channel_id']);
    }

	public function list( $code )
	{
		$dataList = ProductList::getList( $code );

		return view( 'product.list', ['data' => $dataList] );
	}
	
	/**
	 * 添加转入转出记录
	 *
	 * @param $code
	 *
	 * @return mixed
	 */
	public function addForm( $code )
	{
        try {
            $product = Product::getOneByCode($code);

            return view('product.form', ['data' => $product]);
        } catch (\Throwable $ex) {
            dd($ex);
        }
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
