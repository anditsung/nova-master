<?php

namespace Tsung\NovaMaster\Http\Controllers;


use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    public function noImage()
    {
        return response()->file(__DIR__ . '/../../../image/no-image.png');
    }
}
