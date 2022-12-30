<?php

namespace App\Http\Controllers\jwt;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        $users = User::get();
        return response()->json($users);
    }
}
