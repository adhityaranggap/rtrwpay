<?php

namespace App\Helpers;
/**
 * @author Achmad Munandar
 */
class MessageHelper
{

    public static function unprocessableEntity($validator)
    {
        return response()->json([
            "code"      =>  500,
            "status"    =>  false,
            "message"   =>  "form tidak lengkap/sesuai",
            "data"      =>  $validator
        ], 500);
    }
}