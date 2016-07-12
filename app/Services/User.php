<?php

namespace App\Services;

use JWTAuth;
use App\User;

Class User {
    
    public static function generateToken($user) {
        if ($token = JWTAuth::fromUser($user)) {
            return $token;
        }
    }

    public static function getAuthenticatedUser() {
        try {
            return JWTAuth::parseToken()->authenticate();
        } catch(\Exception $e) {
            return false;
        }
    }
    
}