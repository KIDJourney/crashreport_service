<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">添加管理人员</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label>账号</label>
            <input class="form-control" name="repairer_login">
        </div>
        <div class="form-group">
            <label>密码</label>
            <input class="form-control" name="repairer_passwd">
        </div>
        <div class="form-group">
            <label>姓名</label>
            <input class="form-control" name="repairer_name">
        </div>
        <div class="form-group">
            <label>电话</label>
            <input class="form-control" name="repairer_tel">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">提交</button>
            <a class="btn btn-default" onclick="window.history.back()">返回</a>
        </div>

        <?php if (isset($info)) { ?>
            <div class="alert alert-info" role="alert">
                <p><strong><?= $info ?></strong></p>
            </div>
        <?php } ?>
    </form>
</div>