@include("header")
<br />
<form class="layui-form" action="/product/add" method="get">
    <input type="hidden" name="channel_id" value="{{ @$id }}" />

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">代码</label>
            <div class="layui-input-block">
                <input type="text" name="code"  placeholder="请输入代码" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <input type="submit" class="layui-btn" value="立即提交">
        </div>
    </div>
</form>


<table class="layui-hide" id="productList"></table>

<script type="text/javascript">
    layui.use('table', function() {
        var table = layui.table;

        //展示已知数据
        table.render({
            elem: '#productList',
            title: '资产资产信息',
            totalRow: true,
            cols: [[ //标题栏
                {field: 'code', title: '代码', width: 80, sort: true, totalRowText: '合计'},
                {field: 'name', title: '名称', width: 200},
                {field: 'amount', title: '本金', sort: true, totalRow: true},
                {field: 'part', title: '份额', totalRow: true},
                {field: 'price', title: '单价', sort: true, totalRow: true},
                {field: 'market', title: '市值', sort: true, totalRow: true},
                {field: 'profit', title: '盈亏', sort: true, totalRow: true},
                {field: 'rate', title: '盈亏率(%)'},
                {field: 'profit_today', title: '日盈亏', sort: true, totalRow: true},
                {field: 'rate_today', title: '日盈亏率(%)'},
                {
                    field: 'id', title: '操作', templet: function (res) {
                        return '<a href="/product/list/' + res.code + '?id='+res.channel_id+'">明细</a>';
                    }
                },
            ]],
            data: <?php echo json_encode($data, JSON_UNESCAPED_UNICODE); ?>,
            even: true,
            limit: 20
        });
    });
</script>

@include("footer")








