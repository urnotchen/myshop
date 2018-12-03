<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;


class SidebarActiveWidget extends Widget
{
    public $activeArr = [];
    public $activeControllerArr = [];
    public $current;
    public $currentController;

    public function init()
    {/*{{{*/
        parent::init();

        if ($this->current === null) {
            $this->current = Yii::$app->controller->id;
        }
        if ($this->currentController === null) {
            $this->currentController = Yii::$app->controller->module->id;
        }
    }/*}}}*/

    public function run()
    {/*{{{*/

        $class = 'treeview ';

        if (empty($this->activeArr))
            return $class;

        # module
        if (!in_array($this->currentController, $this->activeControllerArr))
            return $class;

        # controller
        if (!in_array($this->current, $this->activeArr))
            return $class;

        $class .= ' active';

        return $class;
    }/*}}}*/

}
