<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 18:26
 */

use common\models\base\Course;

/* @var Course $model */

$INDEX = [
    Course::STATUS_PENDING => [
        "color" => "bg-yellow",
        "icon" => "fa-clock-o"
    ],
    Course::STATUS_CLOSE => [
        "color" => "bg-aqua",
        "icon" => "fa-graduation-cap"
    ],
    Course::STATUS_OPEN => [
        "color" => "bg-green",
        "icon" => "fa-book"
    ]
];
/* @var bool $edit */
$targetUrl = "/course/".($edit?"editor":"viewer")."?id=".$model->id;
$targetContent = $edit?"Edit it":"More Info";
?>

<div class="col-lg-3 col-xs-6">
    <div class="small-box <?=$INDEX[$model->status]["color"]?>">
        <div class="inner">
            <h3><?=$model->name?></h3>
            <h4><?=$model->getTeacher()?></h4>
            <p><?=$model->start_at?></p>
        </div>
        <div class="icon">
            <i class="fa <?=$INDEX[$model->status]["icon"]?>"></i>
        </div>
        <a href="<?=$targetUrl?>" class="small-box-footer">
            <?=$targetContent?> <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

