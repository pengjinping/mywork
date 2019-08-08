<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductList;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function index( $id )
	{
		$dataList = Product::getList( $id );
		foreach ( $dataList as &$item ) {
			$item['profit'] = $item['market'] - $item['amount'];
			$item['rate']   = $item['amount'] > 0 ? ( $item['profit'] / $item['amount'] ) * 10000 : 0;
		}
		
		return view( 'product.index', ['data' => $dataList] );
	}
	
	public function list( $code )
	{
		$dataList = ProductList::getList( $code );
		
		return view( 'product.index', ['data' => $dataList] );
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
			$product = Product::findOrFail( $code );
			
			return view( 'index.form', ['data' => $product] );
		} catch ( \Throwable $ex ) {
			dd( $ex );
		}
	}
	
	/**
	 * 添加转入转出记录
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function addList( Request $request )
	{
		ProductList::createOne( $request->all() );
		
		return redirect( '/' );
	}
	
}
