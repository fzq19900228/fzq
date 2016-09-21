<?php 
	//验证码生成方法 
	function get_verify()
	{
		$verify = new \core\lib\verify();
		$verify->length = 4;
		$verify->entry(1);
	}
	//将id 作为数组的key
	function convert_arr_key($arr, $key_name)
	{
		$arr2 = array();
		foreach($arr as $key => $val){
			$arr2[$val[$key_name]] = $val;        
		}
		return $arr2;
	}
