<?php

/**
 * Created by PhpStorm.
 * User: find35.com
 * Date: 15/12/25
 * Time: 上午10:53
 */
class App
{
    protected static $controller = 'Home';//控制器名
    protected static $method = 'index';//方法名
    protected static $pams = array();//其他参数

    /**
     * url重写路由的url地址解析方法
     */
    protected static function paseUrl(){
        // echo "paseUrl";
        // echo "<hr>";
        if(!empty($_GET['url'])){
            $url = explode('/',$_GET['url']);
            //得到控制器
            if(isset($url[0])){
                self::$controller = $url[0];
                unset($url[0]);
            }
            //得到方法名
            if(isset($url[1])){
                self::$method = $url[1];
                unset($url[1]);
            }
            //判断是否有其他参数
            if(isset($url)){
                self::$pams = array_values($url);
                // var_dump(self::$pams);die;
            }
        }
    }

    /**
     * 项目的入口方法
     * @throws Exception
     */
    public static function run(){
        // echo "run";
        // echo "<hr>";

        self::paseUrl();
        //判断是前台还是后台
        if(APP == 'app'){
            //得到控制器的路径
            $url = 'app/controllers/'.self::$controller.'.class.php';
        }
        if(APP == 'web'){
            //得到控制器的路径
            $url = 'controllers/'.self::$controller.'.class.php';
        }
        //判断控制器文件是否存在
        if(file_exists($url)){
            // var_dump(self::$controller);
            $c = new self::$controller;
        }else{
            throw new MyException('控制器不存在');
        }

        //执行方法,判断在home类里面，method是否存在
        if(method_exists($c,self::$method)){
            // var_dump($c);die;
            $m = self::$method;
            
            // var_dump($m);die;
            $new_pams = array();
            $num = count(self::$pams);
            // var_dump(self::$pams[0]);
            // var_dump(self::$pams[1]);die;
            // echo "</br>";
            //传递参数，判断是否有参数

            if($num > 0){
                //判断传递的参数的数量是否是2的倍数
                if($num % 2 == 0){
                    //将参数进行处理
                    //$i = $i + 2
                    for($i=0;$i<$num;$i+=2){
                        // echo $i;
                        $new_pams[self::$pams[$i]] = self::$pams[$i+1];
                    }
                    // var_dump($new_pams);
                }else{
                    throw new MyException('非法参数!');
                }
            }
            $c->$m($new_pams);
        }else{
            throw new MyException('方法不存在');
        }
    }

    /**
     * 自动加载类方法
     * @param $className
     * @throws Exception
     */
    public static function myAutoloader($className){
        // echo "myAutoloader";
        // echo "<hr>";
        if(APP == 'app'){
            //控制器类文件目录
            $controller = 'app/controllers/'.$className.'.class.php';
            //模型类文件目录
            $model = 'app/models/'.$className.'.class.php';
            //核心类文件目录
            $core = 'core/'.$className.'.class.php';
        }

        if(APP == 'web'){
            //控制器类文件目录
            $controller = 'controllers/'.$className.'.class.php';
            //模型类文件目录
            $model = 'models/'.$className.'.class.php';
            //核心类文件目录
            $core = '../core/'.$className.'.class.php';
        }


        if(file_exists($controller)){
            require_once $controller;
        }else if(file_exists($model)){
            require_once $model;
        }else if(file_exists($core)){
            require_once $core;
        }else{
            throw new MyException('类文件不存在');
        }
    }
}