@include("header")
<br />
<form class="layui-form" action="/product/addList" method="post">
    @csrf
    <input type="hidden" name="channel_id" value="{{ @$product['channel_id'] }}" />
    <input type="hidden" name="code" value="{{ @$product['code'] }}" />

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">产品名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{ @$product['name'] }}" class="layui-input" readonly="true">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">操作类型</label>
            <div class="layui-input-block">
                <input type="radio" name="type" value="1" title="买入" checked="">
                <input type="radio" name="type" value="0" title="赎回">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">交易金额</label>
            <div class="layui-input-block">
                <input type="text" name="amount" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">交易份额</label>
            <div class="layui-input-block">
                <input type="text" name="part" value="" class="layui-input">
            </div>
        </div>

    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">手续费</label>
            <div class="layui-input-block">
                <input type="text" name="hand" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-inline" style="margin-left: 40px;">
            <input type="submit" class="layui-btn" value="立即提交">
        </div>
    </div>
</form>

<table class="layui-hide" id="productLog"></table>

<script type="text/javascript">
    layui.use('table', function() {
        var table = layui.table;

        //展示已知数据
        table.render({
            elem: '#productLog',
            title: '资产买卖记录',
            cols: [[ //标题栏
                {field: 'type_name', title: '类型', width: 80},
                {field: 'amount', title: '金额', width: 120},
                {field: 'part', title: '份额'},
                {field: 'hand', title: '手续费'},
                {field: 'change_after', title: '变更后金额'},
                {field: 'date', title: '日期'}
            ]],
            data: <?php echo json_encode($data, JSON_UNESCAPED_UNICODE); ?>,
            even: true,
            limit: 20
        });
    });
</script>

@include("footer")