<?php

namespace App\Http\Controllers;

use App\Console\Commands\SummaryDayCommand;
use App\Console\Commands\SummaryRunCommand;
use App\Models\Channel;
use App\Models\ChannelList;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	/**
	 * 获取投资渠道信息
	 */
    public function index()
    {
        (new SummaryRunCommand())->handle();
        //(new SummaryDayCommand())->handle();

	    $dataList = Channel::getList();
	    
        return view('index.index', ['data' => $dataList]);
    }
	
	/**
	 * 添加转入转出记录
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function addForm( $id )
	{
		try {
			$channel = Channel::findOrFail( $id );
			
			return view( 'index.form', ['data' => $channel] );
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
		ChannelList::createOne( $request->all() );
		
		return redirect( '/' );
	}
 
}
