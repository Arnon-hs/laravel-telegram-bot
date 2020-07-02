<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use App\TelegramUser;

class TelegramController extends Controller
{
	public function webhook()
	{
		$telegram = Telegram::getWebhookUpdates()['message'];

		if(!TelegramUser::find($telegram['from']['id'])){
			TelegramUser::create(json_decode($telegram['from'], true));
		}

		Telegram::commandsHandler(true);
	}
}
