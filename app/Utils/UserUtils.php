<?php

namespace App\Utils;

use Illuminate\Http\Request;

class UserUtils
{
    public $user;

    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    public function getCurrentUser()
    {
        return $this->user;
    }
}
