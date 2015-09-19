<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">编辑用户信息</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label class="control-label">用户账号</label>

            <input disabled="disabled" class="form-control" value="<?= $data->user_login ?>">
        </div>
        <div class="form-group">
            <label>用户名称</label>
            <input id="user_nickname" class="form-control" name="user_nickname" value="<?= $data->user_nickname ?>">
        </div>
        <div class="form-group">
            <label>联系方式</label>
            <input id="user_tel" class="form-control" name="user_tel" value="<?= $data->user_tel ?>">
        </div>
        <button id="submit" type="submit" class="btn btn-default">Submit</button>
        <?php if (isset($info)) { ?>
            <div class="alert alert-info" role="alert">
                <p><strong><?= $info ?></strong></p>
            </div>
        <?php } ?>
    </form>
</div>
