<?php
class Tpl{
	private $html;

	public function __construct($tpl_name){
		$this->html = file_get_contents('tpl/' . $tpl_name . '.tpl.html');
	}

	public function set($page_data){
		if(is_array($page_data)){

			foreach($page_data as $key=>$value){
				$this->html = str_replace('[' . strtoupper($key) . ']', $value, $this->html);
			}

		// global replacements
		global $config;
		$this->html = str_replace('[HOME]', $config['home'], $this->html);
		
		}
	}

	public function __tostring(){
		return (string)$this->html;
	}
}
?>