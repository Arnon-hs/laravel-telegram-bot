<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class ParseController extends Controller
{
	public $crawler;
	public $html;
	public $defaultUrl;

	public function __construct()
	{
		$this->defaultUrl = DEFAULT_URL;
	}

	public function getLinks()
	{
		try {
			do {
				dump($this->defaultUrl);
				$html = Recipe::init($this->defaultUrl);
				$this->crawler = new Crawler($html, null, DEFAULT_URL);
				$nodeValues = $this->crawler->filter('.card .card__content > a')->each(function (Crawler $node, $i) {
					$url = $node->link()->getUri();
					$recipe = new Recipe();
					echo $recipe->url = $url;
					echo $recipe->name = $node->filter('.title')->text();
					//$recipe->save();
					return $url;
				});
				echo PHP_EOL. $this->defaultUrl = $this->crawler->filter('.paginator__nav_next')->link()->getUri();
				$paginateNext = $this->defaultUrl;
				//				unset($html, $nodeValues, $paginateNext);
			} while (!empty($paginateNext));
		} catch (\Exception $e){
			echo PHP_EOL. $e->getMessage() .PHP_EOL;
		}
	}
}
