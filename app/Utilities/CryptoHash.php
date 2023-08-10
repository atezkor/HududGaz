<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Hash;


trait CryptoHash {

    private function compare($pass, $hashed): bool {
        return HASH::check($pass, $hashed);
    }

    private function hashed(string $password): string {
        return Hash::make($password);
    }
}
