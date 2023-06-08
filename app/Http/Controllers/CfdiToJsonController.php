<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CfdiToJsonController extends Controller
{
    public function cfdiToJson(): Response
    {
        return Inertia::render('CfdiToJson/Index');
    }
}
