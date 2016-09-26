<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 22:08
 */

namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * Class CourseParticipants
 * @package common\models\base
 * @property int id
 * @property int course_id
 * @property int user_id
 * @property string name
 */
class CourseParticipants extends ActiveRecord
{
    public function getCourse()
    {
        return $this->hasOne(Course::className(),['id' => 'course_id']);
    }
    public function getUser()
    {
        return $this->hasOne(Profile::className(),['id' => 'user_id']);
    }
    public function rules()
    {
        return [
            [['name','course_id','user_id'], 'required'],
        ];
    }
}