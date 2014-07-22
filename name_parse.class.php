<?php
class name_parse{
	var $suffix;
	var $names;

	public function __construct(){
		// Варианты суффиксов отчества в русском языке
		$this->suffix = array(
				'ович',
				'овна',
				'евич',
				'евна',
				'ич',
				'ична'
		);
	}

	public function init_name_db($db_name){
		// База имен с возможными отчествами
		$name_db = file($db_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		// Конвертируем в массив
		foreach($name_db as $key => $value){
			$value = explode(",", $value);
			$index = $value[0];
			unset($value[0]);

			$this->names[$index] = array_values($value);
		}
	}

	public function analyze($input){
		// array_search регистрозависим. Приводим отчества к регистру, который в базе. Todo: избавиться от регистрозависимости.
		$input = mb_convert_case(strtolower($input), MB_CASE_TITLE, "UTF-8");

		// Сначала ищем по базе
		foreach($this->names as $key => $name){
			$index = array_search($input, $name);
			if($index!==false){
				$the_name = $key;
				break;
			}
		}

		// Если не найдено в базе, то пробуем получить имя отбрасыванием суффикса
		if(empty($the_name)){
			foreach ($this->suffix as $key => $value) {
				if(preg_match('/'.$value.'$/', $input)){
					$the_name = str_replace($value, "", $input);
					break;
				}
			}
			$out = array('patronymic'=>$input,'name' => $the_name, 'matched_db' => 0);
		} else {
			$out = array('patronymic'=>$input,'name' => $the_name, 'matched_db' => 1);
		}
		return $out;
	}

	// Шаблон для вывода пользователю
	public function print_result($result){
		if(!empty($result['name'])){
			// Если имя получено отбрасыванием суффикса, то точность не 100%
			if(!$result['matched_db']){
				$probably = 'предположительно ';
			}
			$result =  "Отчество <strong>{$result['patronymic']}</strong> {$probably}образовано от имени <strong>{$result['name']}</strong>";
		} else {
			$result =  "Не удалось определить имя, от которого было образовано отчество <strong>{$result['patronymic']}</strong>";
		}
		return $result;
	}
}