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

/**
 * PHP常用数组排序方法
 * Class ArrayToSort
 * @package arr\sort
 */
class ArrayToSort
{

    /**
     * 对外调用方法：快速排序,适合数字类型的数组快速排序
     * @param $arr array    整个序列
     * 平均时间复杂度为O(nlog2n)：快速排序最好情况下的时间复杂度为O(nlog2n)，待排序列越接近无序，本算法效率越高。最坏情况下的时间复杂度为O(n2)，待排序列越接近有序，本算法效率越低
     * 空间复杂度为O(log2n)
     */
    public static function quickSort(&$arr){
        $length = count($arr);
        self::quickSortRecursion($arr,0,$length-1);
        return $arr;
    }

    /**
     * 堆栈排序
     * @param $arr
     */
    public static function hadpSort(&$arr){
        $count = count($arr);
        //先将数组构造成大根堆（由于是完全二叉树，所以这里用floor($count/2)-1，下标小于或等于这数的节点都是有孩子的节点)
        for($i = floor($count / 2) - 1;$i >= 0;$i --){
            self::heapAdjust($arr,$i,$count);
        }
        for($i = $count - 1;$i >= 0;$i --){
            //将堆顶元素与最后一个元素交换，获取到最大元素（交换后的最后一个元素），将最大元素放到数组末尾
            self::swap($arr,0,$i);
            //经过交换，将最后一个元素（最大元素）脱离大根堆，并将未经排序的新树($arr[0...$i-1])重新调整为大根堆
            self::heapAdjust($arr,0,$i-1);
        }
    }


    /**
     * 冒泡排序
     * @param $arr
     * 在要排序的一组数中，对当前还未排好的序列，从前往后对相邻的两个数依次进行比较和调整，让较大的数往下沉，较小的往上冒。即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
     */
    public static function bubbleSort($arr){
        $len=count($arr);
        //该层循环控制 需要冒泡的轮数
        for($i=1;$i<$len;$i++)
        { //该层循环用来控制每轮 冒出一个数 需要比较的次数
            for($k=0;$k<$len-$i;$k++)
            {
                if($arr[$k]>$arr[$k+1])
                {
                    self::swap($arr,$k+1,$k);
                }
            }
        }
        return $arr;
    }

    /**
     * 选择排序
     * @param $arr
     * 在要排序的一组数中，选出最小的一个数与第一个位置的数交换。然后在剩下的数当中再找最小的与第二个位置的数交换，如此循环到倒数第二个数和最后一个数比较为止。
     */
    public static function selectSort($arr){
        //双重循环完成，外层控制轮数，内层控制比较次数
        $len=count($arr);
        for($i=0; $i<$len-1; $i++) {
            //先假设最小的值的位置
            $p = $i;
            for($j=$i+1; $j<$len; $j++) {
                //$arr[$p] 是当前已知的最小值
                if($arr[$p] > $arr[$j]) {
                    //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
                    $p = $j;
                }
            }
            //已经确定了当前的最小值的位置，保存到$p中。如果发现最小值的位置与当前假设的位置$i不同，则位置互换即可。
            if($p != $i) {
                self::swap($arr,$p,$i);
            }
        }
        //返回最终结果
        return $arr;
    }

    /**
     * 插入排序
     * @param $arr
     * 在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，使得这n个数也是排好顺序的。如此反复循环，直到全部排好顺序。
     */
    public static function insertSort($arr){
        $len=count($arr);
        for($i=1; $i<$len; $i++) {
            $tmp = $arr[$i];
            //内层循环控制，比较并插入
            for($j=$i-1;$j>=0;$j--) {
                if($tmp < $arr[$j]) {
                    //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;
                } else {
                    //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                    break;
                }
            }
        }
        return $arr;
    }
    /**
     * 快速排序递归地对序列分区排序
     * @param $arr array    整个序列
     * @param $left  int    待排序的序列左端
     * @param $right int    待排序的序列右端
     */
    private static function quickSortRecursion(&$arr,$left,$right){
        if($left >= $right){
            return false;
        }
        $p = self::quickPartition($arr,$left,$right);
        //对基准点左右区域递归调用排序算法
        self::quickSortRecursion($arr,$left,$p-1);
        self::quickSortRecursion($arr,$p+1,$right);
    }

    /**
     * 快速排序分区操作
     * @param $arr array 整个序列
     * @param $left  int 待排序的序列左端
     * @param $right int 待排序的序列右端
     */
    private static function quickPartition(&$arr,$left,$right){
        //优化1：从数组中随机选择一个数与最左端的数交换，达到随机挑选的效果
        //这个优化使得快速排序在应对近似有序数组排序时，迭代次数更少，排序算法效率更高
        self::swap($arr,$left,rand($left+1,$right));
        $v = $arr[$left];
        $j = $left;
        for ($i=$left+1; $i<=$right; $i++) {
            if ($arr[$i] < $v) {
                $j++;
                self::swap($arr,$i,$j);
            }
        }
        self::swap($arr,$left,$j);
        return $j;
    }

    /**
     * 堆栈排序 根节点最大的完全二叉树
     * @param $arr
     * @param $start
     * @param $end
     */
    private static function heapAdjust(&$arr,$start,$end){
        $temp = $arr[$start];
        //沿关键字较大的孩子节点向下筛选
        //左右孩子计算（我这里数组开始下标识 0）
        //左孩子2 * $start + 1，右孩子2 * $start + 2
        for($j = 2 * $start + 1;$j <= $end;$j = 2 * $j + 1){
            if($j != $end && isset($arr[$j + 1]) && $arr[$j] < $arr[$j + 1]){
                $j ++; //转化为右孩子
            }
            if($temp >= $arr[$j]){
                break;  //已经满足大根堆
            }
            //将根节点设置为子节点的较大值
            $arr[$start] = $arr[$j];
            //继续往下
            $start = $j;
        }
        $arr[$start] = $temp;
    }
    /**
     * 交换数组的两个元素，即把$j位置的元素给$i，$i位置的元素给$j，互换位置
     * @param $arr
     * @param $i
     * @param $j
     */
    private static function swap(&$arr,$i, $j){
        $tmp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $tmp;
    }

}