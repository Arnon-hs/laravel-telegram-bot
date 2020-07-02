<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	protected $table = 'url';

    public static function init($url = DEFAULT_URL)
	{
		$curl = curl_init($url);
		// ПОДГОТОВКА ЗАГОЛОВКОВ
		$uagent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36";
		// ВСЯКИЕ ПАРАМЕТРЫ
		curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_COOKIE, "PMBC=96152e8e9a0168a731539c5e52c6b39a; PHPSESSID=jl0i13pn3157qca807jgp0jqa7;");
		$page = curl_exec($curl);
		curl_close($curl);

		return $page;
	}
}
