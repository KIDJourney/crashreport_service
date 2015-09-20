<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">编辑维修人员信息</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label>维修人员姓名</label>
            <input class="form-control" name="repairer_name" value="<?= $data->repairer_name ?>">
        </div>

        <div class="form-group">
            <label>维修人员电话</label>
            <input class="form-control" name="repairer_tel" value="<?= $data->repairer_tel ?>">
        </div>
        <div class="form-group">     <button type="submit" class="btn btn-default">Submit</button> </div>
        <?php if (isset($info)) { ?>
            <div class="alert alert-info" role="alert">
                <p><strong><?= $info ?></strong></p>
            </div>
        <?php } ?>
    </form>
</div>