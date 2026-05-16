<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

class FCMService
{
    public static function send($token, $title, $body)
    {
        // $factory = (new Factory)
        //     ->withServiceAccount(
        //         json_decode(env('FIREBASE_CREDENTIALS_JSON'), true)
        //     );
        Log::info('FCM MASUK SERVICE');

        if (!$token) {
            Log::error('FCM TOKEN KOSONG');
            return;
        }

        try {
            // $factory = (new Factory)
            //     ->withServiceAccount(storage_path('app/firebase/firebase.json'));
            $factory = (new Factory)
                ->withServiceAccount(
                    json_decode(env('FIREBASE_CREDENTIALS_JSON'), true)
                );

            $messaging = $factory->createMessaging();

            $message = [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ];

            $result = $messaging->send($message);

            Log::info('FCM SUCCESS', ['result' => $result]);
            return $result;
            // sleep(3);

            // return $messaging->send($message);
        } catch (\Throwable $e) {
            Log::error('FCM ERROR', [
                'message' => $e->getMessage()
            ]);
        }
    }
}
