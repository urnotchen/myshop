<?php

namespace common\components;

class TimeFormatter
{

    public $dateFormat     = 'Y-m-d';
    public $timeFormat     = 'H:i:s';
    public $datetimeFormat = 'Y-m-d H:i:s';

    private $_todayTimestamp, $_thisYear, $_NextYear;

    public function timeA($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $thisYear = $this->getThisYearTimestamp();
        $nextYear = $this->getNextYearTimestamp();
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        if ($timestamp < $thisYear || $timestamp > $nextYear) {
            return date('Y-m-d H:i', $timestamp);
        } elseif ($timestamp < $todayTimestamp || $timestamp >= $tomorrowTimestamp) {
            return date('m月d日 H:i', $timestamp);
        } else {
            $seconds = time() - $timestamp;
            if($seconds >= 0){
                if($seconds < 60){
                    return '刚刚';
                }else if($seconds < 3600) {
                    $minutes = round($seconds / 60);
                    return $minutes . '分钟前';
                }
            }
            return '今天 ' . date('H:i', $timestamp);
        }
    }


    public function dateA($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $thisYear = $this->getThisYearTimestamp();
        $nextYear = $this->getNextYearTimestamp();
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        if ($timestamp < $thisYear || $timestamp > $nextYear) {
            return date('Y-m-d', $timestamp);
        } elseif ($timestamp < $todayTimestamp || $timestamp >= $tomorrowTimestamp) {
            return date('m月d日', $timestamp);
        } else {
            return '今天';
        }
    }

    public function getTodayTimestamp()
    {/*{{{*/
        if ($this->_todayTimestamp === null) {
            $this->_todayTimestamp = strtotime(date('Y-m-d'));
        }
        return $this->_todayTimestamp;
    }/*}}}*/

    public function getThisYearTimestamp()
    {/*{{{*/
        if ($this->_thisYear === null) {
            $this->_thisYear = strtotime(date('Y').'-01-01');
        }
        return $this->_thisYear;
    }/*}}}*/

    public function getNextYearTimestamp()
    {/*{{{*/
        if ($this->_NextYear === null) {
            $this->_NextYear = strtotime((date('Y')+1).'-01-01');

        }
        return $this->_NextYear;
    }/*}}}*/

}
