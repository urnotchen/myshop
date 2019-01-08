<?php

namespace frontend\modules\v1\components;

class QueryParamAuth extends \yii\filters\auth\QueryParamAuth
{

    public $tokenParam = 'token';

}
