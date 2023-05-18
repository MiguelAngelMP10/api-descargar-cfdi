<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CfdiToJsonController extends Controller
{
    public function cfdiToJson(Request $request): Response
    {
        return Inertia::render('CfdiToJson/Index');
    }
}
