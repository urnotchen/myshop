<?php

namespace frontend\components\rest;

use Yii;


class Pagination extends \yii\data\Pagination
{

    /*
     * !! 在对外的应用接口, 如果超出最后一页应该显示无数据, 而不是显示最后一页
     */
    public $validatePage = false;

    public $defaultPageSize = 15;

    public $pageSizeLimit = [1, 50];

    protected $_pageCapacity;

    /*
     * @type integer
     * 如果此值为null, pagesize == defaultPageSize
     * 如果数据总数不大于此属性, 则此值优先级高于defaultPageSize
     * 如果数据总数大于此属性, 则此值优先级低于defaultPageSize
     */
    public $maxPageSize;

    /**
     * @brief 是否还有下页
     *
     * @return boolean
     */
    public function hasMore()
    {/*{{{*/
        return $this->getPage() + 1 < $this->getPageCount();
    }/*}}}*/

    /**
     * * 不再接受request中的pageSizeParam
     * * 尽可能合并多页为单页, 依据maxPageSize
     *
     * @return integer
     */
    public function getPageSize()
    {/*{{{*/
        if ($this->_pageCapacity === null) {
            $this->dynamicPageSize();
        }

        return $this->_pageCapacity;
    }/*}}}*/

    protected function dynamicPageSize()
    {/*{{{*/
        if ( $this->maxPageSize === null ) {
            if (empty($this->pageSizeLimit)) {
                $this->setPageSize($this->defaultPageSize);
            } else {
                $pageSize = (int) $this->getQueryParam($this->pageSizeParam, $this->defaultPageSize);
                $this->setPageSize($pageSize, true);
            }
        } else {
            if ($this->totalCount <= $this->maxPageSize) {
                $this->setPageSize($this->totalCount);
            } else {
                $this->setPageSize($this->defaultPageSize);
            }
        }
    }/*}}}*/

    public function setPageSize($value, $validatePageSize = false)
    {/*{{{*/
        if ($value === null) {
            $this->_pageCapacity = null;
        } else {
            $value = (int) $value;
            if ($validatePageSize && isset($this->pageSizeLimit[0], $this->pageSizeLimit[1]) && count($this->pageSizeLimit) === 2) {
                if ($value < $this->pageSizeLimit[0]) {
                    $value = $this->pageSizeLimit[0];
                } elseif ($value > $this->pageSizeLimit[1]) {
                    $value = $this->pageSizeLimit[1];
                }
            }
            $this->_pageCapacity = $value;
        }
    }/*}}}*/

}
