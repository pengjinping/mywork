<html>
    <body>
    <form action="/product/addList" method="post">
        @csrf
        <input type="hidden" name="channel_id" value="{{ @$data['channel_id'] }}" />
        <input type="hidden" name="code" value="{{ @$data['code'] }}" />
        <p>产品名称：{{ @$data['name'] }}</p>
        <p>操作类型: <input type="radio" name="type" value="0" checked>赎回
            <input type="radio" name="type" value="1">买入
        </p>
        <p>交易金额: <input type="text" name="amount" /></p>
        <p>交易份额: <input type="text" name="part" /></p>
        <p>手续费: <input type="text" name="hand" /></p>
        <input type="submit" value="提交" />
    </form>
    </body>
</html>