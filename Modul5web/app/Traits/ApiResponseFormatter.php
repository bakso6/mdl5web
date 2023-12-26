<?php

namespace app\Traits;

// UNTUK FORMATTING RESPONSE
trait ApiResponseFormatter
{
    public function apiResponse($code = 200, $massage = "success", $data = [])
    {
        //DARI PARAETER AKAN DI FORMAT MENJADI SEPERTI DIBAWAH INI
        return json_encode([
            "code" => $code,
            "message" => $massage,
            "data" => $data
        ]);
    }
}
