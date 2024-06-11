<?php

namespace App\Services;

use GuzzleHttp\Client;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;

class TelegramService
{
    public function __construct() {
    }

    public function sendSchedule(int $tg_id, $date) {
        if ($tg_id !== 0) {
            try {
                Request::sendMessage(['chat_id' => $tg_id, 'text' => '🕐 Запланирован урок на ' . $date->format('H:i d.m.Y')]);
            } catch (\Exception $exception) {
                // Send logs
                throw $exception;
            }
        }
    }

    public function sendHomeworkNotify(int $tg_id, $title) {
        if ($tg_id !== 0) {
            try {
                Request::sendMessage(['chat_id' => $tg_id, 'text' => '🆕  На сайте появилось новое задание на тему "' . $title . '"']);
            } catch (\Exception $exception) {
                // Send logs
                throw $exception;
            }
        }
    }

    public function sendNotesNotify(int $tg_id, $title) {
        if ($tg_id !== 0) {
            try {
                Request::sendMessage(['chat_id' => $tg_id, 'text' => '🌞 На сайте появились новые конспекты на тему "' . $title . '"']);
            } catch (\Exception $exception) {
                // Send logs
                throw $exception;
            }
        }
    }
}
