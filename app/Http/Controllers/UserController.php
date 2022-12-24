<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

}
