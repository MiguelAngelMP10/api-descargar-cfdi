<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SendCerKeyController extends Controller
{

    public function sendCerKey(Request $request)
    {
        $RFC = $request->get('RFC');
        $pathCer = $request->file('cer')->storeAs(
            'datos/' . $RFC,
            $RFC . '.cer'
        );

        $pathKey = $request->file('key')->storeAs(
            'datos/' . $RFC,
            $RFC . '.key'
        );

        return response()->json([
            'pathCer' => $pathCer,
            'pathKey' =>  $pathKey,
        ]);
    }
}