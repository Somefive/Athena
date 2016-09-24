<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/23
 * Time: 16:02
 */

use common\models\base\Profile;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model Profile */

$this->title = 'Profile';

?>

<div class="site-profile">

    <div class="row">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Profile Settings</h3>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => 'profile-form', 'enableClientValidation' => false]); ?>

                <?= $form->field($model, 'school_id') ?>
                <?= $form->field($model, 'first_name') ?>
                <?= $form->field($model, 'last_name') ?>
                <?= $form->field($model, 'nickname') ?>
                <?= $form->field($model, 'department') ?>
                <?= $form->field($model, 'gender')->dropDownList(['male' => 'male','female' => 'female']) ?>
                <?= $form->field($model, 'class') ?>
                <?= $form->field($model, 'contact') ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>
