<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/28
 * Time: 19:52
 */

namespace common\models\base;


use yii\db\ActiveRecord;
use DateTime;

/**
 * Class Message
 * @package common\models\base
 * @property int id
 * @property int from
 * @property int to
 * @property string type
 * @property string content
 * @property string created_at
 * @property string viewed_at
 * @property bool viewed
 */
class Message extends ActiveRecord
{
    const TYPE_VALIDATION_REQUEST = "VALIDATION_REQUEST";
    const TYPE_PLAIN_TEXT = "PLAIN_TEXT";

    public function rules()
    {
        return [
            [['from','to','content'], 'safe'],
            ['type', 'default', 'value' => self::TYPE_PLAIN_TEXT],
            ['type', 'in', 'range' => [self::TYPE_PLAIN_TEXT, self::TYPE_VALIDATION_REQUEST]],
            ['created_at', 'default', 'value' => ''],
            ['viewed_at', 'default', 'value' => ''],
            [['from','to'], 'required'],
        ];
    }

    public function getViewed()
    {
        return $this->viewed_at > $this->created_at;
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->created_at = (new DateTime())->format('Y-m-d H:i:s');
    }
}