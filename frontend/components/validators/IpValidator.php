<?php

namespace frontend\components\validators;

use yii\base\InvalidConfigException;
use common\components\ValidateErrorCode;

/**
 * IpValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 12:07
 */
class IpValidator extends \yii\validators\IpValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if (!$this->ipv4 && !$this->ipv6) {
            throw new InvalidConfigException('Both IPv4 and IPv6 checks can not be disabled at the same time');
        }

        if (!defined('AF_INET6') && $this->ipv6) {
            throw new InvalidConfigException('IPv6 validation can not be used. PHP is compiled without IPv6');
        }

        if ($this->message === null) {
            $this->message = ValidateErrorCode::IP;
        }
        if ($this->ipv6NotAllowed === null) {
            $this->ipv6NotAllowed = ValidateErrorCode::IP_NOT_V6;
        }
        if ($this->ipv4NotAllowed === null) {
            $this->ipv4NotAllowed = ValidateErrorCode::IP_NOT_V4;
        }
        if ($this->wrongCidr === null) {
            $this->wrongCidr = ValidateErrorCode::IP_WRONT_CIDR;
        }
        if ($this->noSubnet === null) {
            $this->noSubnet = ValidateErrorCode::IP_WITH_SUBNET;
        }
        if ($this->hasSubnet === null) {
            $this->hasSubnet = ValidateErrorCode::IP_NO_SUBNET;
        }
        if ($this->notInRange === null) {
            $this->notInRange = ValidateErrorCode::IP_IN_RANGE;
        }
    }/*}}}*/
}
