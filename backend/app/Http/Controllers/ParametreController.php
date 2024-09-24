<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class ParametreController extends Controller
{
    public function showAll(){
        $user = Auth::user();
       if ($user->hasRole('admin')) {
            $smtpConfig = [
                'MAIL_USERNAME' => env('MAIL_USERNAME'),
                'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
                'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
                'DAILY_API_KEY' => env('DAILY_API_KEY'),
                'ABLY_API_KEY' => env('ABLY_API_KEY'),
                'DB_DATABASE' => env('DB_DATABASE'),
                'DB_USERNAME' => env('DB_USERNAME'),
                'DB_PASSWORD' => env('DB_PASSWORD'),
            ];

            return response()->json($smtpConfig);
       }else{
          return response()->json(['message' => 'Non autorisé'], 403);
       } 
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $validator = Validator::make($request->all(), [
                'MAIL_USERNAME' => 'nullable|string',
                'MAIL_PASSWORD' => 'nullable|string',
                'MAIL_FROM_ADDRESS' => 'nullable|email',
                'MAIL_FROM_NAME' => 'nullable|string',
                'DAILY_API_KEY' => 'nullable|string',
                'ABLY_API_KEY' => 'nullable|string',
                'DB_DATABASE' => 'nullable|string',
                'DB_USERNAME' => 'nullable|string',
                'DB_PASSWORD' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            try {
                $envFilePath = base_path('.env');
                $envContents = file_get_contents($envFilePath);

                $replacements = [
                    'MAIL_USERNAME=' . env('MAIL_USERNAME') => 'MAIL_USERNAME=' . $request->input('MAIL_USERNAME'),
                    'MAIL_PASSWORD=' . env('MAIL_PASSWORD') => 'MAIL_PASSWORD=' . $request->input('MAIL_PASSWORD'),
                    'MAIL_FROM_ADDRESS=' . env('MAIL_FROM_ADDRESS') => 'MAIL_FROM_ADDRESS=' . $request->input('MAIL_FROM_ADDRESS'),
                    'MAIL_FROM_NAME=' . env('MAIL_FROM_NAME') => 'MAIL_FROM_NAME=' . $request->input('MAIL_FROM_NAME'),
                    'DAILY_API_KEY=' . env('DAILY_API_KEY') => 'DAILY_API_KEY=' . $request->input('DAILY_API_KEY'),
                    'ABLY_API_KEY=' . env('ABLY_API_KEY') => 'ABLY_API_KEY=' . $request->input('ABLY_API_KEY'),
                    'DB_DATABASE=' . env('DB_DATABASE') => 'DB_DATABASE=' . $request->input('DB_DATABASE'),
                    'DB_USERNAME=' . env('DB_USERNAME') => 'DB_USERNAME=' . $request->input('DB_USERNAME'),
                    'DB_PASSWORD=' . env('DB_PASSWORD') => 'DB_PASSWORD=' . $request->input('DB_PASSWORD'),
                ];

                foreach ($replacements as $search => $replace) {
                    $envContents = str_replace($search, $replace, $envContents);
                }

                file_put_contents($envFilePath, $envContents);

                // Clear the configuration cache to make sure changes take effect
                Artisan::call('config:cache');

                return response()->json(['message' => 'updated successfully.']);
            } catch (\Exception $e) {
                Log::error('Failed to update .env file: ' . $e->getMessage());
                return response()->json(['message' => 'Failed to update configuration'], 500);
            }
        } else {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    }
    
}
