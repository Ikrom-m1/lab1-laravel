<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTO\ClientInfoDTO;

class InfoController extends Controller
{
    // Метод для отображения информации о версии PHP
    public function phpInfo()
    {
        return response()->json([
            'php_version' => phpversion(),
            'php_settings' => [
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'date_timezone' => date_default_timezone_get(),
                'loaded_extensions' => get_loaded_extensions(),
            ],
        ]);
    }

    // Метод для отображения информации о клиенте (IP и user agent)
    public function clientInfo(Request $request)
    {
        // Используем DTO для обработки данных клиента
        $clientInfo = new ClientInfoDTO(
            $request->ip(),
            $request->userAgent()
        );

        return response()->json($clientInfo);
    }

    // Метод для отображения информации о базе данных
    public function databaseInfo()
    {
        return response()->json([
            'database_connection' => env('DB_CONNECTION'),
            'database_name' => env('DB_DATABASE'),
            'database_host' => env('DB_HOST'),
        ]);
    }
}


