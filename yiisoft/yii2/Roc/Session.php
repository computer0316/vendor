<?php

namespace yii\Roc;

use Yii;

class Session{
	/*
		添加一个 session , 如果存在则覆盖
	*/
	public static function add($name, $value, $lifetime = 18000 ){
		$session = Yii::$app->session;
		$session[$name . '.value']		= $value;
		$session[$name . '.lifetime']	= time() + $lifetime;
	}

	/*
		删除一个 session
	*/
	public static function remove($name){
		$session = Yii::$app->session;
		$session->remove($name . '.value');
		$session->remove($name . '.lifetime');
	}

	/*
		读取一个session。
		如果session已经过期，则返回null
	*/
	public static function get($name){
		$session = Yii::$app->session;
		if(!isset($session[$name . '.value'])){
			return null;
		}
		if(time() < $session[$name . '.lifetime']){
			return $session[$name . '.value'];
		}
		else{
			return null;
		}
	}

	/*
		读取一个 session 的过期时间，单位：秒
		如果 session 已经过期或者不存在，则返回 0
	*/
	public static function checkTimeout($name){
		$session = Yii::$app->session;
		if(isset($session[$name . '.value'])){
			return $session[$name . '.lifetime'] - time();
		}
		else{
			return 0;
		}
	}

}



