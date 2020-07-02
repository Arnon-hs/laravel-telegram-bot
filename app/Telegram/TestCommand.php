<?php

namespace App\Telegram;

use App\User;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
/**
 * Class HelpCommand.
 */
class TestCommand extends Command
{
	/**
	 * @var string Command Name
	 */
	protected $name = 'test';

	/**
	 * @var string Command Description
	 */
	protected $description = 'Test command';

	/**
	 * {@inheritdoc}
	 */
	public function handle($arguments)
	{
//		$commands = $this->telegram->getCommands();
//
//		$text = '';
//		foreach ($commands as $name => $handler) {
//			$text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
//		}
		$this->replyWithChatAction(['action' => Actions::TYPING]);
		$user = \App\User::find(2);

		$this->replyWithMessage(['text' => "Почта пользователя: " . $user->email]);
		$telegram_user = \Telegram::getWebhookUpdates()['message'];
		$text = sprintf('%s: %s'.PHP_EOL, "Ваш номер чата", $telegram_user['from']['id']); //todo !empty()
//		$text .= sprintf('%s: %s'.PHP_EOL, "Ваше имя пользователя", $telegram_user['from']['username']);

		$keyboard = [
			['7', '8', '9'],
			['4', '5', '6'],
			['1', '2', '3'],
			['0']
		];

		$reply_markup = \Telegram::replyKeyboardMarkup([
			'keyboard' => $keyboard,
			'resize_keyboard' => true,
			'one_time_keyboard' => true
		]);

		$response = \Telegram::sendMessage([
			'chat_id' => $telegram_user['from']['id'],
			'text' => 'Tap tab',
			'reply_markup' => $reply_markup
		]);

		$messageId = $response->getMessageId();

		$this->replyWithMessage(compact('text'));
	}
}
