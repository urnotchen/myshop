<?php

namespace common\widgets;

use Yii;
use yii\base\Object;
use yii\helpers\Url;
use yii\helpers\Html;

class SidebarItems
{

    private $_items = [];

    public $defaultItem = [];

    public function init()
    {/*{{{*/

        $this->_items = $this->defaultItem;
    }/*}}}*/

    public function getItems()
    {/*{{{*/
        return array_filter($this->_items, function ($item) {
            return ! empty($item);
        });
    }/*}}}*/

    public function push(array $items)
    {/*{{{*/
        $this->_items[] = $items;
    }/*}}}*/

    public function unshift(array $item)
    {/*{{{*/
        $itemArr = $this->_items;
        array_unshift($itemArr, $item);
        $this->_items = $itemArr;
    }/*}}}*/

    public function setItems($items)
    {/*{{{*/
        $this->_items = $items;
    }/*}}}*/

}
