<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
// use \SebastianBergmann\CodeCoverage\StaticAnalysis\Cache;

use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function login()
    {
        return view('loginPage');
    }

    public function post($slug)
    {
        // return view($slug);
        if (!view()->exists($slug)) abort(404);



        $post = Cache::remember("home.{$slug}", 3600, function () use ($slug) {

            return view($slug)->render();
        });

        return $post;
    }
}
