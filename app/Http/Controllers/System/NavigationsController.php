<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NavigationsController extends Controller
{
    public function index() {
        return Inertia::render('System/Navigations/Index');
    }
}
