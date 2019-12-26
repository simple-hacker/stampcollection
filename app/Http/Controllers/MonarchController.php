<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Monarch;

class MonarchController extends Controller
{
    public function index() {
        $monarchs = Monarch::all();
        return view('admin.monarchs', compact('monarchs'));
    }
}
