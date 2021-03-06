<?php

namespace backend\modules\order;

use backend\assets\AppAsset;
use common\widgets\SidebarActiveWidget;

use yii\helpers\Url;
use Yii;

class Module extends \yii\base\Module {

    const CLASS_CONTENT      = 0,
        CLASS_TASK           = 1;

    public $controllerNamespace = 'backend\modules\order\controllers';

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->on(\yii\base\Module::EVENT_BEFORE_ACTION, [$this, 'handleSidebarItems']);

        \yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function($event){
            AppAsset::addPageScript($event->sender, '/js/ajaxFileUpload.js');
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

        $content_accounts = [];

        return [
            'label' => '<span class="fa fa-copy (alias)"></span> <span>订单列表</span>',
            'items' => [],
            'url' => ['/order/order/index'],
            'options' => [
                'class' => SidebarActiveWidget::widget([
                    'activeArr' => ['order'],
                    'activeControllerArr' => [
                        'order',
                    ],
                ])
            ],
        ];
    }
    public function handleSidebarItems($event)
    {/*{{{*/

        $items = Yii::$app->sidebarItems->getItems();
        $items[] = $this->getContent();
        $items[] = $this->getAccounts();

        Yii::$app->sidebarItems->setItems($items);


    }


    protected function getAccounts()
    {
        return [
        'label' => '<span class="fa fa-copy (alias)"></span> <span></span>',
        'items' => [],
        'url' => ['/goods/store/index'],
        'options' => [
        'class' => SidebarActiveWidget::widget([
            'activeArr' => ['store'],
            'activeControllerArr' => [
                'store',
            ],
        ])
        ],
    ];

    }/*}}}*/

}

?>