<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $dataList = Channel::getList();
        foreach ($dataList as &$item) {
            $item['profit'] = $item['balance'] + $item['market'] - $item['capital'];
            $item['rate']   = $item['capital'] > 0 ? ($item['profit'] / $item['capital'])*10000 : 0;
        }

        return view('index.welcome', ['data' => $dataList]);
    }
}
