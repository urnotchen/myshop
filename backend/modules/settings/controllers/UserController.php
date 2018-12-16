<?php

namespace backend\modules\settings\controllers;


use backend\modules\settings\models\User;

class UserController extends \yii\base\Controller{


    public function actionCreate()
    {/*{{{*/
        $model = new User();
        $model->scenario = 'create';

        if ($model->load(\Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);

        return $this->render('create', [
            'model' => $model,
        ]);
    }/*}}}*/
}
