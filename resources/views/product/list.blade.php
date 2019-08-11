<html>
<table width="95%">
    <thead>
    <tr>
        <th>类型</th>
        <th>金额</th>
        <th>份额</th>
        <th>手续费</th>
        <th>变更后金额</th>
        <th>日期</th>
    </tr>
    </thead>

    <tbody style="text-align: center">
    @if(!empty($data))
        @foreach($data as $dataItem)
            <tr>
                <td>{{ \App\Models\ProductList::$TYPE_MAP[$dataItem['type']] }}</td>
                <td>{{$dataItem['amount']}}</td>
                <td>{{$dataItem['part']}}</td>
                <td>{{$dataItem['hand']}}</td>
                <td>{{$dataItem['change_after']}}</td>
                <td>{{$dataItem['date']}}</td>
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