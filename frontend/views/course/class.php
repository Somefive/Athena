<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 22:32
 */

/* @var $course_id string */
/* @var $name string */

$this->title = "Class Member"
?>
<?php \yii\widgets\Pjax::begin() ?>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'School ID',
            'value' => function ($data) {
                return $data->relatedRecords["user"]->school_id;
            },
        ],
        [
            'label' => 'Name',
            'value' => function ($data) {
                return $data->relatedRecords["user"]->full_name;
            },
        ],
        [
            'label' => 'Gender',
            'value' => function ($data) {
                return $data->relatedRecords["user"]->gender;
            },
        ],
        [
            'label' => 'Department',
            'value' => function ($data) {
                return $data->relatedRecords["user"]->department;
            },
        ],
        [
            'label' => 'Class',
            'value' => function ($data) {
                return $data->relatedRecords["user"]->class;
            },
        ],
        [
            'label' => 'Contact',
            'value' => function ($data) {
                return $data->relatedRecords["user"]->contact;
            },
        ],
    ]
]);
?>
<?php \yii\widgets\Pjax::end() ?>

