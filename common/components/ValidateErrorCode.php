<?php

namespace common\components;


class ValidateErrorCode
{

    # 必须为字符串
    const STRING                     = 1;
    # 过短
    const STRING_TOO_SHORT           = 2;
    # 过长
    const STRING_TOO_LONG            = 3;
    # 与给定值不一致
    const STRING_NOT_EQUAL           = 4;

    # 上传文件失败
    const FILE                       = 5;
    # 必须有上传文件
    const FILE_REQUIRED              = 6;
    # 过多
    const FILE_TOO_MANY              = 7;
    # 错误的文件扩展名
    const FILE_WRONG_EXTENSION       = 8;
    # 过大
    const FILE_TOO_BIG               = 9;
    # 过小
    const FILE_TOO_SMALL             = 10;
    # 错误的mime
    const FILE_WRONG_MIME_TYPE       = 11;

    # 必须
    const REQUIRED                   = 12;
    # 必须为给定值
    const REQUIRED_MUST_BE           = 13;

    # 必须为布尔值
    const BOOLEAN                    = 14;

    # 与验证码不符
    const CAPTCHA                    = 15;

    # 必须相等 (===, ==)
    const COMPARE_EQUAL              = 16;
    # 必须不能相等 (!=, !==)
    const COMPARE_NOT_EQUAL          = 17;
    # 必须大于给定值 (>)
    const COMPARE_GEATER             = 18;
    # 必须大于等于给定值 (>=)
    const COMPARE_GEATER_OR_EQUAL    = 19;
    # 必须小于给定值 (<)
    const COMPARE_LESS               = 20;
    # 必须小于等于给定值 (<=)
    const COMPARE_LESS_OR_EQUAL      = 21;

    # 必须为日期
    const DATE                       = 22;
    # 过小
    const DATE_TOO_SMALL             = 23;
    # 过大
    const DATE_TOO_BIG               = 24;

    # 必须为数字
    const NUMBER                     = 25;
    # 必须为整型数字
    const NUMBER_INTEGER             = 26;
    # 过小
    const NUMBER_TOO_SMALL           = 27;
    # 过大
    const NUMBER_TOO_BIG             = 28;

    # 给定数据无效
    const EACH                       = 29;

    # 必须为邮箱
    const EMAIL                      = 30;

    # 必须存在
    const EXIST                      = 31;

    # 必须为图片
    const IMAGE                      = 32;
    # 宽过小
    const IMAGE_UNDER_WIDTH          = 33;
    # 高过小
    const IMAGE_UNDER_HEIGHT         = 34;
    # 宽过大
    const IMAGE_OVER_WIDTH           = 35;
    # 高过大
    const IMAGE_OVER_HEIGHT          = 36;

    # 必须在区间内
    const RANGE                      = 37;

    # 必须符合正则
    const REGEX                      = 38;

    # 必须唯一
    const UNIQUE                     = 39;

    # 必须为url
    const URL                        = 40;

    # 必须为ip
    const IP                         = 41;
    # 必须不为 ip v6
    const IP_NOT_V6                  = 42;
    # 必须不为 ip v4
    const IP_NOT_V4                  = 43;
    # 包含错误的子网掩码
    const IP_WRONT_CIDR              = 44;
    # 必须为 ip + subnet
    const IP_WITH_SUBNET             = 45;
    # 必须不包含subnet
    const IP_NO_SUBNET               = 46;
    # 必须在区间内
    const IP_IN_RANGE                = 47;

    # 邮箱未注册
    const EMAIL_NOT_REGISTERED       = 48;
    # 密码不匹配
    const PASSWORD_NOT_MATCH         = 49;

    # 错误的变量类型
    const MEMORY_WRONG_VARIABLE_TYPE = 50;
    # 缺少period_id
    const MEMORY_LACK_OF_PERIOD_ID   = 51;


    # 缺少同步动作
    const SYNC_LACK_OF_ACTION        = 53;

    # 变量类型必须为数组
    const SYNC_ARRAY_NEEDED          = 55;

    # 至少给定一个值
    const REQUIRED_ONE_AT_LEAST      = 56;

    # 复合唯一
    const COMPOSITE_UNIQUE           = 57;

    # 必须为数组
    const MUST_ARRAY                = 58;
    # 过短
    const ARRAY_TOO_SHORT           = 59;
    # 过长
    const ARRAY_TOO_LONG            = 60;

    # token 不匹配
    const TOKEN_NOT_MATCH           = 61;
    # token 过期
    const TOKEN_EXPIRED             = 62;

    const EMAIL_NOT_UNIQUE         = 65;


}
