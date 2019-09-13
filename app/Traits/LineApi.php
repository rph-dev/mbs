<?php
/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
/*
 * This polyfill of hash_equals() is a modified edition of https://github.com/indigophp/hash-compat/tree/43a19f42093a0cd2d11874dff9d891027fc42214
 *
 * Copyright (c) 2015 Indigo Development Team
 * Released under the MIT license
 * https://github.com/indigophp/hash-compat/blob/43a19f42093a0cd2d11874dff9d891027fc42214/LICENSE
 */
/*
 * Last modified by Kongvut Sangkla
 * kongvut@gmail.com
 * 2019-08-29
 */

namespace App\Traits;

/**
 * Trait LineApi
 * @package App\Traits
 */
trait LineApi
{
    /**
     * @var
     */
    protected $channelAccessToken;
    /**
     * @var
     */
    protected $channelSecret;

    /**
     * @return mixed
     */
    public function parseEvents()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            error_log('Method not allowed');
            exit();
        }
        $entityBody = file_get_contents('php://input');
        if (strlen($entityBody) === 0) {
            http_response_code(400);
            error_log('Missing request body');
            exit();
        }
        if (!hash_equals($this->sign($entityBody), $_SERVER['HTTP_X_LINE_SIGNATURE'])) {
            http_response_code(400);
            error_log('Invalid signature value');
            exit();
        }
        $data = json_decode($entityBody, true);
        if (!isset($data['events'])) {
            http_response_code(400);
            error_log('Invalid request body: missing events property');
            exit();
        }
        return $data['events'];
    }

    /**
     * @param $replyToken
     * @param $message
     * @param string $messageType
     * @return array
     */
    public function replyMessage($replyToken, $message, $messageType = 'text')
    {
        // Make a POST Request to Messaging API to reply to sender
        $url = 'https://api.line.me/v2/bot/message/reply';
        $data = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => $messageType,
                    'text' => $message
                ]
            ],
        ];

        return $this->send($data, $url);
    }

    /**
     * @param $toUserId
     * @param $message
     * @param string $messageType
     * @return array
     */
    public function pushMessage($toUserId, $message, $messageType = 'text')
    {
        // Make a POST Request to Messaging API to reply to sender
        $url = 'https://api.line.me/v2/bot/message/push';
        $data = [
            'to' => $toUserId,
            'messages' => [
                [
                    'type' => $messageType,
                    'text' => $message
                ]
            ],
        ];

        return $this->send($data, $url);
    }

    /**
     * @param array $users
     * @param $messages
     * @param string $messageType
     * @return array
     */
    public function multicastMessage(array $users, $messages)
    {
        // Make a POST Request to Messaging API to reply to sender
        $url = 'https://api.line.me/v2/bot/message/multicast';
        $data = [
            'to' => $users,
            'messages' => $messages,

        ];

        return $this->send($data, $url);
    }

    /**
     * @param $data
     * @param $url
     * @return array
     */
    protected function send($data, $url)
    {
        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->channelAccessToken);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return compact('result', 'http_status');
    }

    /**
     * @param $body
     * @return string
     */
    protected function sign($body)
    {
        $hash = hash_hmac('sha256', $body, $this->channelSecret, true);
        $signature = base64_encode($hash);
        return $signature;
    }
}
