<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/28
 * Time: 19:27
 */
use yii\helpers\Html;

$this->title = "Validation List";
?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'created_at',
        'school_id',
        'name',
        'gender',
        'department',
        'class',
        'contact',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '<span>{validate-allow} {validate-deny}</span>',
            'buttons' => [
                'validate-allow' => function ($url, $model, $key) {
                    return Html::a('<span class="btn btn-success">Agree</span>','/site/validate?id='.$model['message_id'].'&type=agree');
                },
                'validate-deny' => function ($url, $model, $key) {
                    return Html::a('<span class="btn btn-danger">Disagree</span>','/site/validate?id='.$model['message_id'].'&type=disagree');
                },
            ]
        ],
    ],
]);
?>

