<html>
<table width="95%">
    <thead>
    <tr>
        <th>代码</th>
        <th>名称</th>
        <th>本金</th>
        <th>份额</th>
        <th>市值</th>
        <th>盈亏</th>
        <th>盈亏率</th>
        <th>明细</th>
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
                <td>{{$dataItem['market']}}</td>
                <td>{{$dataItem['profit']}}</td>
                <td>{{ intval($dataItem['rate']) / 100}}%</td>
                <td><a href="/product/list/{{$dataItem['code']}}">明细</a></td>
                <td><a href="/product/addForm/{{$dataItem['code']}}">明细</a></td>
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