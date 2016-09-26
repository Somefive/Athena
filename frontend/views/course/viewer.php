<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 19:55
 */

$this->title = 'Course';

use common\models\base\Course;
use common\models\base\CourseParticipants;
/* @var Course $model */

$type = "success";
if($model->status==Course::STATUS_PENDING) $type = "warning";
else if($model->status==Course::STATUS_CLOSE) $type = "primary";

$cps = CourseParticipants::findAll(['course_id'=>$model->id, 'user_id'=>$model->teacher_id]);
?>

<div class="course-viewer">

    <div class="row">
        <div class="box box-<?=$type?>">
            <div class="box-header with-border">
                <h1 class="box-title">Course Viewer</h1>
            </div>
            <div class="box-body">
                <h1 style="text-align: center"><?=$model->name?></h1>
                <h2 style="text-align: center"><?=$model->getTeacher()?></h2>
                <h3><strong>Abstract:&nbsp;</strong><?=$model->abstract?></h3>
                <h4><strong>Status:&nbsp;</strong><?=$model->start_at?></h4>
                <h4><strong>Start Time:&nbsp;</strong><?=$model->status?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <?php foreach($cps as $cp):?>
            <a class="btn btn-app" href="/course/class?course_id=<?=$cp->course_id?>&name=<?=$cp->name?>">
                <span class="badge bg-purple"><?= CourseParticipants::find()->where(['course_id'=>$cp->course_id, 'name'=>$cp->name])->count()?></span>
                <i class="fa fa-users"></i> <?= $cp->name ?>
            </a>
        <?php endforeach?>
    </div>

</div>

