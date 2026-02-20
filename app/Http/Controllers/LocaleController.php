<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch($locale, Request $request)
    {
        if (! in_array($locale, ['en', 'es'])) {
            abort(404);
        }

        session(['locale' => $locale]);

        return back();
    }
}
