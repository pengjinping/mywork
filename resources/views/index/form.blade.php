@include("header")
<br />
<form class="layui-form" action="/addList" method="post">
    @csrf
    <input type="hidden" name="group_id" value="{{ @$data['id'] }}" />

    <div class="layui-form-item">
        <label class="layui-form-label">组名称</label>
        <div class="layui-input-inline">
            <input type="text" name="name" value="{{ @$data['name'] }}" class="layui-input" readonly="true">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">操作类型</label>
        <div class="layui-input-inline">
            <input type="radio" name="type" value="1" title="转入" checked="">
            <input type="radio" name="type" value="0" title="转出">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">交易金额</label>
        <div class="layui-input-inline">
            <input type="text" name="amount" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline" style="margin-left: 40px;">
            <input type="submit" class="layui-btn" value="立即提交">
        </div>
    </div>
</form>

<script type="text/javascript">
    layui.use('table', function() {});
</script>
@include("footer")