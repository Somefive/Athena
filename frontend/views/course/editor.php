<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 15:50
 */

use common\models\base\Course;
use dosamigos\datepicker\DatePicker;
use common\models\base\CourseParticipants;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model Course */
/* @var $classModel CourseParticipants */
/* @var $classes array */

$this->title = 'Course';

?>


<div class="course-editor">

    <div class="row">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Course Editor</h3>
            </div>
            <div class="box-body">
                <?php $form = \yii\bootstrap\ActiveForm::begin(['id' => 'course-form', 'enableClientValidation' => false]); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'abstract') ?>

                <div class="form-group field-course-status">
                    <label class="control-label" for="course-start_at">StartAt</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'start_at',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);?>
                    <p class="help-block help-block-error"></p>
                </div>

                <?= $form->field($model, 'status')->dropDownList(\common\widgets\ArrayFlattener::flatten(Course::STATUS)); ?>
                <div class="form-group">
                    <?= \yii\bootstrap\Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'course-button']) ?>
                </div>

                <?php \yii\bootstrap\ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <?php if(isset($classModel->course_id)): ?>
    <div class="row">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Class Editor</h3>
            </div>
            <div class="box-body">
                <?php $form = \yii\bootstrap\ActiveForm::begin(['id' => 'class-form', 'enableClientValidation' => false]); ?>
                <?= $form->field($classModel, 'course_id')->hiddenInput() ?>
                <?= $form->field($classModel, 'name') ?>
                <div class="form-group">
                    <?= \yii\bootstrap\Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'class-button']) ?>
                </div>
                <?php \yii\bootstrap\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="row" style="float: left">
        <?php foreach($classes as $cp): ?>
            <a class="btn btn-app" href="/course/class?course_id=<?=$cp->course_id?>&name=<?=$cp->name?>">
                <span class="badge bg-purple"><?= CourseParticipants::find()->where(['course_id'=>$cp->course_id, 'name'=>$cp->name])->count()?></span>
                <i class="fa fa-users"></i> <?= $cp->name ?>
            </a>
        <?php endforeach ?>
    </div>
    <?php endif ?>
</div>
