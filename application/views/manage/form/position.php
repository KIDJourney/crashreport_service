<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">编辑故障地点</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label>故障ID</label>
            <input class="form-control" disabled="disabled" value="<?= $data->id ?>">
        </div>

        <div class="form-group">
            <label>故障地点名称</label>
            <input class="form-control" name="pos_name" value="<?= $data->pos_name?>">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <?php if (isset($info)) { ?>
            <div class="alert alert-info" role="alert">
                <p><strong><?= $info ?></strong></p>
            </div>
        <?php } ?>
    </form>
</div>