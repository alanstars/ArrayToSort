<?php
// +----------------------------------------------------------------------
// | CoolCms [ DEVELOPMENT IS SO SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018-2019 http://www.coolcms.ccn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: Alan <251956250@qq.com>
// +----------------------------------------------------------------------

namespace arr\sort;


class Demo
{
    public function index(){
        $arr = [];
        for ($i = 0;$i < 1000;$i++){
            $arr[$i] = rand(10,100000);
        }
        echo "<pre>";
        $t1 = microtime(true);
        ArrayToSort::quickSort($arr);
        $t2 = microtime(true);
        echo '快速排序耗时'.round($t2-$t1,10).'<br>';

        $t3 = microtime(true);
        ArrayToSort::hadpSort($arr);
        $t4 = microtime(true);
        echo '堆栈耗时'.round($t4-$t3,10).'<br>';

        $t5 = microtime(true);
        ArrayToSort::bubbleSort($arr);
        $t6 = microtime(true);
        echo '冒泡耗时'.round($t6-$t5,10).'<br>';

        $t7 = microtime(true);
        ArrayToSort::selectSort($arr);
        $t8 = microtime(true);
        echo '选择耗时'.round($t8-$t7,10).'<br>';

        $t9 = microtime(true);
        ArrayToSort::insertSort($arr);
        $t10 = microtime(true);
        echo '选择耗时'.round($t10-$t9,10).'<br>';

    }
}