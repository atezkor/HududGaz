<?php

namespace App\Utilities;


trait CodeGenerator {

    private function qrcodeGenerate($length = 10): string {
        $characters = 'abc@defghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, $char_length - 1)];
        }

        return $result . time();
    }
}
