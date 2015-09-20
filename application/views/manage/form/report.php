<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">编辑报告</h2>

    <form action="<?php echo current_url(); ?>" method="post">
        <div class="form-group">
            <label>故障地点</label>
            <select name="report_pos" class="form-control">
                <?php foreach ($positions as $position): ?>
                    <option
                        value="<?= $position->id; ?>" <?php if ($data->report_pos == $position->id) echo 'selected="selected"'; ?>><?= $position->pos_name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>故障详情</label>
            <input type="text" name="report_info" class="form-control" value="<?= $data->report_info ?>">
        </div>
        <div class="form-group">
            <label>故障类型</label>
            <select name="report_type" class="form-control">
                <?php foreach ($types as $type): ?>
                    <option
                        value="<?= $type->id; ?>" <?php if ($data->report_type == $type->id) echo 'selected="selected"'; ?>><?= $type->type_name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="radio-inline">
                <input type="radio" name="report_status" <?= isset($report_status['0']) ? $report_status['0'] : ''; ?>
                       value="0">尚未维修
            </label>
            <label class="radio-inline">
                <input type="radio" name="report_status" <?= isset($report_status['1']) ? $report_status['1'] : ''; ?>
                       value="1">已被接受
            </label>
            <label class="radio-inline">
                <input type="radio" name="report_status" <?= isset($report_status['2']) ? $report_status['2'] : ''; ?>
                       value="2">已完成
            </label>
        </div>
        <div class="form-group">     <button type="submit" class="btn btn-default">提交</button> </div>
        <?php if (isset($info)) { ?>
            <div class="alert alert-info" role="alert">
                <p><strong><?= $info ?></strong></p>
            </div>
        <?php } ?>
    </form>
</div>