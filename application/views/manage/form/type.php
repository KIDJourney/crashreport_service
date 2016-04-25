<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">编辑事件类型</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label>事件类型ID</label>
            <input class="form-control" disabled="disabled" value="<?= $data->id ?>">
        </div>

        <div class="form-group">
            <label>事件类型名称</label>
            <input class="form-control" name="type_name" value="<?= $data->type_name ?>">
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