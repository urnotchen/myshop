<?php

namespace frontend\models;

class FUser extends \common\models\FUser  implements \yii\web\IdentityInterface {

    use \frontend\traits\UserIdentityTrait;

}