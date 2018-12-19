<?php

namespace frontend\traits;


trait ModelPrepareTrait
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ValidateExceptionTrait;
    use \common\traits\ErrorsJsonTrait;

    public function prepare($rawParams, $runValidation = true)
    {/*{{{*/
        $this->load( $rawParams , '');

        if ($runValidation) $this->validate();

        return true;
    }/*}}}*/
}    
