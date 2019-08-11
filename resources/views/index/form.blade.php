<html>
<body>
<form action="/addList" method="post">
    @csrf
    <input type="hidden" name="channel_id" value="{{ @$data['id'] }}" />
    <p>渠道名称：{{ @$data['name'] }}</p>
    <p>类型: <input type="radio" name="type" value="0" checked>转出
        <input type="radio" name="type" value="1">转入
    </p>
    <p>转账金额: <input type="text" name="amount" /></p>
    <input type="submit" value="Submit" />
</form>

</body>
</html>