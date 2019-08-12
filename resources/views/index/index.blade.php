<html>
<table width="95%">
    <thead>
    <tr>
        <th>名称</th>
        <th>本金</th>
        <th>余额</th>
        <th>市值</th>
        <th>总资产</th>
        <th>盈亏</th>
        <th>盈亏率</th>
        <th>日盈亏</th>
        <th>明细</th>
        <th>添加</th>
    </tr>
    </thead>

    <tbody style="text-align: center">
    @if(!empty($data))
        @foreach($data as $dataItem)
            <tr>
                <td>{{$dataItem['name']}}</td>
                <td>{{$dataItem['capital']}}</td>
                <td>{{$dataItem['balance']}}</td>
                <td>{{$dataItem['market']}}</td>
                <td>{{$dataItem['market'] + $dataItem['balance']}}</td>
                <td>{{ round($dataItem['profit'], 2)}}</td>
                <td>{{ round($dataItem['rate']) / 100}}%</td>
                <td>{{ round($dataItem['market'] - $dataItem['yestoday'],2)}}</td>
                <td><a href="/product/{{$dataItem['id']}}">明细</a></td>
                <td><a href="/addForm/{{$dataItem['id']}}">添加</a></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td rowspan="8"></td>
        </tr>
    @endif
    </tbody>

</table>

</html>