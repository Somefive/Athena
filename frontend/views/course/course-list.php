<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 18:51
 */

/* @var array $viewParams */
/* @var string $itemView */

$this->title = 'Course List';
?>

<?php if(Yii::$app->user->can('Teacher')):?>
    <a class="btn btn-app" href="/course/editor">
        <i class="fa fa-edit"></i> Create New Course
    </a>
<?php endif ?>

<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => $itemView,
    'viewParams' => $viewParams
]); ?>
