<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/22
 * Time: 18:54
 */
namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * Class Profile
 * @package common\models\base
 * @property int id
 * @property string school_id
 * @property string first_name
 * @property string last_name
 * @property string nickname
 * @property string gender
 * @property string department
 * @property string class
 * @property string contact
 * @property string full_name
 */
class Profile extends ActiveRecord {

    const GENDER_MALE = "male";
    const GENDER_FEMALE = "female";

    public function rules()
    {
        return [
            ['gender', 'default', 'value' => self::GENDER_MALE],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
        ];
    }

    /**
     * @param $id
     * @return Profile
     */
    public static function findById($id)
    {
        $profile = parent::findOne($id);
        if($profile == null)
        {
            $profile = new Profile(['id'=>$id]);
            $profile->save();
        }
        return $profile;
    }

    public function getFull_name()
    {
        return $this->last_name.' '.$this->first_name;
    }
}