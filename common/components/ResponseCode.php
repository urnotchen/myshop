<?php

namespace common\components;

class ResponseCode{

    const PERSIST_DATA_ERROR = 10001,
        ENTITY_NOT_FOUND = 10002;
    const DATABASE_SAVE_FAILED = 10003;

    //订单参数错误
    const ORDER_PARAMS_ERROR = 10010;
    //商品数量不足
    const ORDER_GOODS_NOT_ENOUGH = 10011;
    //用户购买额度不足
    const ORDER_GOODS_PRE_NOT_ENOUGH = 10012;
    //当前时间不在售卖时间内
    const ORDER_GOODS_NOT_IN_TIME = 10013;
    //订单状态有误
    const ORDER_STATUS_NOT_CORRECT = 10014;
    //用户无权操作
    const USER_ACCESS_FORBIDDEN = 10015;
    #用户分销商有误
    const USER_DISTRIBUTOR_FAILED = 10016;

    # 无效 access_token
    const INVALID_ACCESS_TOKEN = 40001;
    # access_token 已过期
    const ACCESS_TOKEN_EXPIRED = 40002;
    # user login failed
    const USER_LOGIN_FAILED = 40003;
    # 验证请求参数数据失败
    const REQUEST_PARAMS_VALIDATE_FAILED = 40004;

}