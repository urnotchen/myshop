<?php

namespace backend\modules\settings;

use backend\assets\AppAsset;
use common\widgets\SidebarActiveWidget;

use yii\helpers\Url;
use Yii;

class Module extends \yii\base\Module {

    const CLASS_CONTENT      = 0,
        CLASS_TASK           = 1;

    public $controllerNamespace = 'backend\modules\settings\controllers';

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

//        $this->on(\yii\base\Module::EVENT_BEFORE_ACTION, [$this, 'handleSidebarItems']);

        \yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function($event){
//            AppAsset::addPageScript($event->sender, '/js/ajaxFileUpload.js');
//            AppAsset::addPageScript($event->sender, '/js/weibo.js');
//            AppAsset::addPageScript($event->sender, '/js/moment.js');
//            AppAsset::addPageCss($event->sender, '/css/weibo.css');


        });

        Yii::configure(Yii::$app, ['components' => [
            'timeFormatter' => [
                'class' => 'common\components\TimeFormatter',
            ],

        ]]);
    }

    protected function getContent()
    {

        $content_accounts = $this->getAccounts( Yii::$app->getRequest()->get('WeibocontentSearch')['account_open_id'], self::CLASS_CONTENT);

        return [
            'label' => '<span class="fa fa-copy (alias)"></span> <span>微博内容</span>',
            'items' => $content_accounts,
            'options' => [
                'class' => SidebarActiveWidget::widget([
                    'activeArr' => ['weibo-content'],
                    'activeControllerArr' => [
                        'weibo-content',
                    ],
                ])
            ],
        ];
    }
    public function handleSidebarItems($event)
    {/*{{{*/

        $items = Yii::$app->sidebarItems->getItems();
        $items[] = $this->getContent();
//        $items[] = $this->getTask();

        Yii::$app->sidebarItems->setItems($items);


    }


    protected function getAccounts($account_open_id, $class)
    {/*{{{*/
        $idName = WeiboAccount::getSidebarItems($class);
        $items = [];


        $model = 'weibo-content';

        foreach ($idName as $id => $name) {


            $linkOptions = [];
            if ( $account_open_id !== null && $id == $account_open_id ) {
                $linkOptions = ['class' => 'active-item'];
            }
            $search = 'WeibocontentSearch[account_open_id]';

            $items[] = [
                'label' => $name,
                'url'   => \yii\helpers\Url::to([
                    "/weibo-task/{$model}",
                    $search => $id,
                ]),
            ];

        }


        array_unshift($items, ['label' => '全部', 'url' => Url::to(["/schedule/{$model}/index"]), 'linkOptions' => $linkOptions]);

        if($class)
            $items[] = ['label' => '垃圾箱' , 'url' => Url::to(["/schedule/task/trashbin"]), 'linkOptions' => $linkOptions];

        return $items;
    }/*}}}*/

}

?>