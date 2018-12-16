<?php

namespace frontend\components\rest;

/**
 * FormInterface class file.
 *
 * 单个 Form 尽量只做一个业务逻辑
 *
 * @Author haoliang
 * @Date 20.11.2015 14:01
 */
interface FormInterface
{

    /**
     * 业务逻辑的入口尽量只有一个,
     * 所需变量尽量以属性注入的方式传入
     *
     * @return
     */
    public function save($runValidation = true);

}
