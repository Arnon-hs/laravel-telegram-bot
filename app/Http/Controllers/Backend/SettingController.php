<?php

namespace App\Http\Controllers\Backend;

use App\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
	{
    	return view('backend.setting', Setting::getSettings());
	}

	public function store(Request $request)
	{
		Setting::where('key', '!=', NULL)->delete();

		foreach ($request->except('_token') as $key => $value)
		{
			$setting = new Setting();
			$setting->key = $key;
			$setting->value = $value;
			$setting->save();
		}
		return redirect()->route('admin.setting.index');
	}

	public function setwebhook(Request $request)
	{
		$result = $this->sendTelegramData('setWebhook', [
			'query' => ['url' => $request->url . '/' . \Telegram::getAccessToken()]
		]);
		return redirect()->route('admin.setting.index')->with('status', $result);
	}

	public function getwebhookinfo(Request $request)
	{
    	$result = $this->sendTelegramData('getWebhookInfo');
		return redirect()->route('admin.setting.index')->with('status', $result);
	}

	public function sendTelegramData($route = '', $params = [], $method = 'POST')
	{
		$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.telegram.org/bot' . \Telegram::getAccessToken() . '/'] );
		//dd($method, $route, $params);
		$result = $client->request($method, $route, $params);
		return (string) $result->getBody();
	}
//	private function AccessToken($route = '', $params = [])
//	{
//		$client = new Client();
//		$URI = 'https://api.telegram.org/bot' . \Telegram::getAccessToken() . '/';
//		$params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded'];
//		try{
//			$response = $client->post($URI, $params);
//			var_dump($response);
//		}
//		catch (RequestException $e){
//			echo 'Error: ' . $e->getMessage();
//		}
//
//	}
}
