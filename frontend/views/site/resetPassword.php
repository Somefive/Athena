<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$fieldOptions = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$this->title = 'Reset password';

?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Athena</b>THU</a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Please choose your new password:</p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'password', $fieldOptions)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block btn-flat']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
