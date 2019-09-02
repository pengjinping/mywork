@include("header")

<fieldset class="layui-elem-field site-demo-button" style="margin-top: 30px;">
    <div>
        <button type="button" class="layui-btn" onclick="window.location.href='/refresh'">刷新统计</button>
        <button type="button" class="layui-btn" onclick="window.location.href='/refreshFund'">更新基金值</button>
    </div>
</fieldset>
<br />
<table class="layui-hide" id="channelList"></table>

<script type="text/javascript">
    layui.use('table', function() {
        var table = layui.table;

        //展示已知数据
        table.render({
            elem: '#channelList',
            title: '资产渠道表',
            totalRow: true,
            cols: [[ //标题栏
                //{field: 'id', title: 'ID', width: 80, sort: true},
                {field: 'name', title: '名称', width: 110, totalRowText: '合计'},
                {field: 'capital', title: '本金', sort: true, totalRow: true},
                {field: 'balance', title: '余额', totalRow: true},
                //{field: 'market', title: '市值', sort: true, totalRow: true},
                {field: 'market_balance', title: '总资产', sort: true, totalRow: true},
                {field: 'profit', title: '盈亏', sort: true, totalRow: true},
                {field: 'rate', title: '盈亏率(%)'},
                {field: 'today', title: '日盈亏', sort: true, totalRow: true},
                {field: 'week', title: '周盈亏', sort: true, totalRow: true},
                {field: 'month', title: '月盈亏', sort: true, totalRow: true},
                {
                    field: 'id', title: '操作', templet: function (res) {
                        return '<a href="/product/' + res.id + '">明细</a> | ' +
                            '<a href="/addForm/' + res.id + '">添加</a>';
                    }
                },
            ]],
            data: <?php echo json_encode($data, JSON_UNESCAPED_UNICODE); ?>,
            even: true
        });
    });
</script>

@include("footer")
