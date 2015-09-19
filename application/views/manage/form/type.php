<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">编辑故障类型</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label>故障类型ID</label>
            <input class="form-control" disabled="disabled" value="<?= $data->id ?>">
        </div>

        <div class="form-group">
            <label>故障类型名称</label>
            <input class="form-control" name="type_name" value="<?= $data->type_name?>">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <?php if (isset($info)) { ?>
            <div class="alert alert-info" role="alert">
                <p><strong><?= $info ?></strong></p>
            </div>
        <?php } ?>
    </form>
</div>