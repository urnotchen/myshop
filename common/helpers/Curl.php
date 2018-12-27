<?php
namespace common\helpers;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Curl
{
    /**
     * @param $url
     * @param bool $https
     * @param bool $autoRedirect
     * @param bool $rmResponseHeader
     * @return mixed
     */
    public static function httpGet($url, $https = false, $autoRedirect = true, $rmResponseHeader = true)
    {
        $opt = [
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            CURLOPT_RETURNTRANSFER => true,
        ];

        $opt = $https ? self::setHttpsOpt($opt) : $opt;
        $opt = $autoRedirect ? self::setAutoRedirectOpt($opt) : $opt;
        $opt = $rmResponseHeader ? self::setRmResponseHeaderOpt($opt) : $opt;

        $curl = curl_init($url);

        curl_setopt_array($curl, $opt);

        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * @param $url
     * @param bool $cookie
     * @param array $header
     * @param bool $https
     * @param bool $autoRedirect
     * @param bool $rmResponseHeader
     * @return mixed
     */
    public static function cookieCurl($url, $cookie = false, array $header = [], $https = false, $autoRedirect = true, $rmResponseHeader = true)
    {
        // Cookie相关设置，这部分设置需要在所有会话开始之前设置
        date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
        $opt = [
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_COOKIE => $cookie,
        ];

        $opt = $https ? self::setHttpsOpt($opt) : $opt;
        $opt = $autoRedirect ? self::setAutoRedirectOpt($opt) : $opt;
        $opt = $rmResponseHeader ? self::setRmResponseHeaderOpt($opt) : $opt;

        $curl = curl_init($url);

        curl_setopt_array($curl, $opt);

        $output = curl_exec($curl);	// 执行
        
        curl_close($curl);			// 关闭cURL

        return $output;
    }

    /**
     * @param $url
     * @param array $postData
     * @param bool $cookie
     * @param string $referer
     * @param array $header
     * @param bool $https
     * @param bool $autoRedirect
     * @param bool $rmResponseHeader
     * @param int $timeout
     * @return mixed
     */
    public static function cookieCurlPost(
        $url, array $postData, $cookie = false, $referer = '', array $header = [],
        $https = false, $autoRedirect = true, $rmResponseHeader = true, $timeout = 200)
    {
        $data = http_build_query($postData);

        $header[] = 'Content-Length: ' . strlen($data);

        // Cookie相关设置，这部分设置需要在所有会话开始之前设置
        date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
        $opt = [
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_COOKIE => $cookie,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_REFERER => $referer,
            CURLOPT_TIMEOUT => $timeout
        ];

        $opt = $https ? self::setHttpsOpt($opt) : $opt;
        $opt = $autoRedirect ? self::setAutoRedirectOpt($opt) : $opt;
        $opt = $rmResponseHeader ? self::setRmResponseHeaderOpt($opt) : $opt;

        $curl = curl_init($url);            // 初始化

        curl_setopt_array($curl, $opt);

        $output = curl_exec($curl);	// 执行

        curl_close($curl);			// 关闭cURL
        return $output;
    }

    /**
     * 获取跳转后的链接
     * @param $url
     * @return bool
     */
    public static function getRedirectUrl($url)
    {
        $opt = [
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            CURLOPT_RETURNTRANSFER => true,
        ];

        $opt = self::setAutoRedirectOpt($opt);

        $curl = curl_init($url);

        curl_setopt_array($curl, $opt);

        $output = curl_exec($curl);	// 执行

        $Headers =  curl_getinfo($curl);
        curl_close($curl);

        if ($output != $Headers) {
            return  $Headers["url"];
        }

        return false;
    }

    /**
     * https请求 不验证证书和hosts
     * @param $opt
     * @return array
     */
    public static function setHttpsOpt($opt)
    {
        $opt[CURLOPT_SSL_VERIFYHOST] = false;
        $opt[CURLOPT_SSL_VERIFYPEER] = false;
        return $opt;
    }

    /**
     * 这样能够让cURL支持页面链接跳转
     * @param $opt
     * @return array
     */
    public static function setAutoRedirectOpt($opt)
    {
        $opt[CURLOPT_FOLLOWLOCATION] = true;
        return $opt;
    }

    /**
     * 不要http header 加快效率
     * @param $opt
     * @return array
     */
    public static function setRmResponseHeaderOpt($opt)
    {
        $opt[CURLOPT_HEADER] = false;
        return $opt;
    }

}
