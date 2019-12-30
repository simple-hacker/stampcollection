<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Issue;
use App\Stamp;
use App\Collection;

class AdminController extends Controller
{
    public function index() {

        $usersCount = User::count();
        $collectionsCount = Collection::count();
        $stampsCount = Stamp::count();
        $issuesCount = Issue::count();

        return view('admin.index', compact('usersCount', 'collectionsCount', 'stampsCount', 'issuesCount'));
    }
}
