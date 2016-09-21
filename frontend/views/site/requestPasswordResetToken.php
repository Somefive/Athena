<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$fieldOptions = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$this->title = 'Request password reset';
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Athena</b>THU</a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Please fill out your email. A link to reset password will be sent there.</p>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'email', $fieldOptions)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::submitButton('Send', ['class' => 'btn btn-warning btn-block btn-flat']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <a href="/site/login" class="text-center">Log in</a><br/>
        <a href="/site/signup" class="text-center">Sign up</a>
    </div>

</div>
