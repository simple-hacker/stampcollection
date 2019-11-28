<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Stamp;
use App\Collection;

class HomeController extends Controller
{
    /**
     * Shows the public front welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usersCount = User::count();
        $collectionsCount = Collection::count();
        $stampsCount = Stamp::count();

        return view('welcome', compact('usersCount', 'collectionsCount', 'stampsCount'));
    }
}
