<?php

//Типа хендлер запроса. Содержит псевдовалидатор и псевдосохранение в БД с возможностью ошибки сохранения

$request = $_POST;

$validation = validate($request, [
	'name',
	'surname',
	'login',
	'password',
]);

if ($validation->fails) {

	foreach ($validation->errors as $error) {
		echo $error.', ';
	}

	exit();

}

$res = fake_sql();

if ($res) {
	echo 'Пользователь успешно создан!';
}
else {
	echo 'Ошибка БД';
}

function fake_sql() {
	return rand(0, 10) > 2;
}

function validate($request, $fields) {

	$res = new stdClass;
	$res->fails = false;
	$res->errors = [];

	foreach ($fields as $field) {
		
		if (!isset($request[$field]) || empty($request[$field])) {

			$res->fails = true;
			array_push($res->errors, 'Поле '. $field .' не может быть пустым!');
		}
	}

	return $res;

}

?>