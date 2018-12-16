<?php

namespace frontend\components\rest;

use Yii;

/**
 * BlueliveMailer class file.
 * @Author haoliang
 * @Date 30.01.2016 16:53
 */
class BlueliveMailer extends \yii\base\Object
{

    public $api = 'http://notification.bluelive.me/api/compose';
    public $created_by = 'api.memory.bluelive.me';

    public function compose($send_to, $subject, $content)
    {/*{{{*/

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->api);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'send_to'    => json_encode($send_to),
            'subject'    => $subject,
            'content'    => $content,
            "created_by" => $this->created_by,
        ], '', '&', PHP_QUERY_RFC3986));

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response === false) {
            throw new \yii\web\HttpException(500, 'send mail failed.');
        }

        return true;
    }/*}}}*/

}
