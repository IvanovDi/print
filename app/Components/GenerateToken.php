<?php

namespace App\Components;

trait GenerateToken
{
    protected function generateToken()
    {
        return md5(str_random(10));
    }
}