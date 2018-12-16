<?php

namespace frontend\components\rest;

class Request extends \yii\web\Request
{

    private $_accessToken;

    public function getAccessToken()
    {/*{{{*/
        if ($this->_accessToken === null) {
            if (isset($_SERVER['HTTP_ACCESS_TOKEN'])) {
                $this->_accessToken = $_SERVER['HTTP_ACCESS_TOKEN'];
            } else {
                $this->_accessToken = '';
            }
        }
        return $this->_accessToken;
    }/*}}}*/

}