<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/24
 * Time: 21:44
 */

namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * Class Course
 * @package common\models\base
 * @property int id
 * @property int teacher_id
 * @property string name
 * @property string abstract
 * @property string start_at
 * @property string status
 */
class Course extends ActiveRecord
{
    const STATUS_PENDING = "pending";
    const STATUS_OPEN = "open";
    const STATUS_CLOSE = "close";

    const STATUS = [self::STATUS_PENDING, self::STATUS_OPEN, self::STATUS_CLOSE];

    public function rules()
    {
        return [
            [['name','abstract','start_at'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['status', 'in', 'range' => self::STATUS],
        ];
    }

    public function getTeacher()
    {
        return Profile::findOne($this->teacher_id)->full_name;
    }

    public function getParticipants()
    {
        return $this->hasMany(Profile::className(),['id'=>'user_id'])
            ->viaTable(CourseParticipants::className(),['course_id' => 'id']);
    }
}

