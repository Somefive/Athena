<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/22
 * Time: 19:08
 */
namespace console\controllers;

use common\models\base\Profile;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        echo "Hello World!";
    }

    public function actionTest($id)
    {
        echo json_encode(Profile::findOne($id)->toArray());
    }

}