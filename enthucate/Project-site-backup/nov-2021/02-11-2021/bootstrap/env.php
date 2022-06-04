<?php
$host = $_SERVER['HTTP_HOST'];
$env_dir = __DIR__.'/../env/';
$request_uri = trim($_SERVER['REQUEST_URI'], "/");

if($host == '192.168.1.19'){
	$request_uri = str_replace('project/laravel/enthucate/public/', '', $request_uri);
}

if($request_uri){
	$company_name = explode("/", $request_uri);
	if(isset($company_name[0]) && file_exists($env_dir.$company_name[0])){
		$dotenv = new \Dotenv\Dotenv($env_dir, $company_name[0]);
		$dotenv->load();
	}
}