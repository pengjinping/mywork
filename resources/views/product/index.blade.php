<html>
<form action="/product/add" method="get">
    <input type="hidden" name="channel_id" value="{{ @$id }}" />
    代号 : <input type="text" name="code" />
    <input type="submit" value="添加" />
</form>
<table width="95%">
    <thead>
    <tr>
        <th>代码</th>
        <th>名称</th>
        <th>本金</th>
        <th>份额</th>
        <th>单价</th>
        <th>市值</th>
        <th>盈亏</th>
        <th>盈亏率</th>
        <th>日盈亏</th>
        <th>日盈亏率</th>
        <th>明细</th>
        <th>操作</th>
    </tr>
    </thead>

    <tbody style="text-align: center">
    @if(!empty($data))
        @foreach($data as $dataItem)
            <tr>
                <td>{{$dataItem['code']}}</td>
                <td>{{$dataItem['name']}}</td>
                <td>{{$dataItem['amount']}}</td>
                <td>{{$dataItem['part']}}</td>
                <td>{{$dataItem['price']}}</td>
                <td>{{$dataItem['market']}}</td>
                <td>{{$dataItem['profit']}}</td>
                <td>{{ intval($dataItem['rate']) / 100}}%</td>
                <td>{{$dataItem['profit_today']}}</td>
                <td>{{ intval($dataItem['rate_today']) / 100}}%</td>
                <td><a href="/product/list/{{$dataItem['code']}}">明细</a></td>
                <td><a href="/product/addForm/{{$dataItem['code']}}">操作</a></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td rowspan="8"></td>
        </tr>
    @endif
    </tbody>

</table>
<h3 style="text-align:center">共计投资本金：{{$total['amount']}}, 目前市值: {{ $total['market'] }},
盈亏金额： {{ $total['profit'] }}, 盈亏率：{{ intval($total['rate']) / 100}}%，
今日盈亏：{{ $total['yesterday'] }}</h3>
</html>