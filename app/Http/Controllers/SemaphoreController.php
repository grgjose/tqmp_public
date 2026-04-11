<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SemaphoreController extends Controller
{
    //
    public function sendMessage(Request $request)
    {
        $response = Http::post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $request->input('number'),
            'message' => $request->input('message'),
            'sendername' => env('SEMAPHORE_SENDER_NAME'),
        ]);

        if ($response->successful()) {
            return response()->json(['status' => 'Message sent successfully']);
        } else {
            return response()->json(['status' => 'Failed to send message'], 500);
        }
    }

    public function sendOTP(Request $request)
    {
        $response = Http::post('https://api.semaphore.co/api/v4/otp', [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $request->input('number'),
            'message' => $request->input('message'),
            'sendername' => env('SEMAPHORE_SENDER_NAME'),
            'code' => $request->input('code'),
        ]);

        if ($response->successful()) {
            return response()->json(['status' => 'OTP sent successfully']);
        } else {
            return response()->json(['status' => 'Failed to send OTP'], 500);
        }
    }
}
