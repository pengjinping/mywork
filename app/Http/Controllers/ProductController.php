<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $dataList = Product::getList($id);
        foreach ($dataList as &$item) {
            $item['profit'] = $item['market'] - $item['amount'];
            $item['rate']   = $item['amount'] > 0 ? ($item['profit'] / $item['amount']) * 10000 : 0;
        }

        return view('product.index', ['data' => $dataList]);
    }
}
