<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/28
 * Time: 21:30
 */
use yii\helpers\Html;
use common\models\base\Message;
/* @var $message Message */
$this->title = "Student List";

?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'user_id',
        'school_id',
        'name',
        'nickname',
        'gender',
        'department',
        'class',
        'contact',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '<span>{contact}</span>',
            'buttons' => [
                'contact' => function ($url, $model, $key) {
                    return Html::a('<span class="fa fa-comment btn-chat">&nbsp;Chat</span>','#',[
                        'data-toggle' => 'modal',
                        'data-target' => '#chat-modal',
                        'data-id' => $model['user_id'],
                        'class' => 'btn btn-success',
                    ]);
                },
            ]
        ],
    ],
]);
?>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'chat-modal',
    'header' => '<h4 class="modal-title">Chat</h4>',
]);
$form = \yii\bootstrap\ActiveForm::begin([
    'action' => '/site/chat-to'
]);
echo $form->field($message,'to')->hiddenInput()->label(false);
echo $form->field($message,'content');
echo Html::submitButton('Send',['class' => 'btn btn-success']);
echo "&nbsp;";
echo Html::button('Close',['class'=>'btn btn-primary', 'data-dismiss'=>'modal']);
\yii\bootstrap\ActiveForm::end();
\yii\bootstrap\Modal::end();
$modelJs = <<<JS
    $('.btn-chat').on('click', function() {
        $('#message-to').val($(this).parent().attr('data-id'));
    });
JS;
$this->registerJs($modelJs);

?>
