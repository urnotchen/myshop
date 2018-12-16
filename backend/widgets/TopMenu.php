<?php

namespace backend\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class TopMenu extends \yii\base\Widget
{

    public $items = [];

    public $commonClass = 'menu-item';
    public $activeClass = 'menu-item-active';

    public function run()
    {/*{{{*/
        $html = '';
        foreach ($this->items as $item) {
            $html .= Html::a(
                $item['text'],
                $item['url'],
                $this->getOptions(
                    ArrayHelper::getValue($item, 'options', []),
                    ArrayHelper::getValue($item, 'activeModule', null)
                )
            );
        }

        return $html;
    }/*}}}*/

    public function getCurrentModule()
    {/*{{{*/
        return Yii::$app->controller->module->id;
    }/*}}}*/

    public function getOptions(array $options, $activeModule = null)
    {/*{{{*/
        $class = isset($options['class']) ? $options['class'] : '';

        $class .= ' ' . $this->commonClass;

        # active
        if ($activeModule !== null && $activeModule == $this->getCurrentModule()) {
            $class .= ' ' . $this->activeClass;
        }

        $options['class'] = $class;

        return $options;
    }/*}}}*/

}
