<?php
/**
 * 项目前台入口文件
 * User: find35.com
 * Date: 15/12/24
 * Time: 下午5:15
 */
echo "<meta charset='utf-8'>";
require_once 'core/App.class.php';
require_once 'config/constants.php';
require_once 'core/function.php';
//注册一个
define('APP','app');//定义一个常量
spl_autoload_register(array('App','myAutoloader'));
try{
	//在执行的过程中，如果捕获到了任何异常，就跳传到 catch
    App::run();
}catch(MyException $e){
    $e->showError($e->getMessage());
}

$db = Model::getStringleton();

//直接执行sql语句
//$result = $db->queryString('select * from users where username=:username',array(':username'=>'zhang'));

//查询某个表
//$result = $db->select('users');

//查询某个表，并增加where条件
//$result = $db->where('where username=:username')->select('users',array(':username'=>'zhang'));

//查询单条数据
//$result = $db->where('where id=:id')->find('users',array(':id'=>'3'));

//插入数据
//$data = array(':username'=>'zhang6',':userpass'=>md5(123456),':create_time2'=>time());
//$result = $db->insert('users',$data);

//更新数据
//$data = array(':username'=>'lisi',':userpass'=>md5(456789));
//$where = array(':id'=>9);
//$result = $db->where('where id=:id')->update('users',$data,$where);

//删除数据
$result = $db->where('where id=:id')->delete('users',array('id'=>9));

echo "<pre>";
print_r($result);