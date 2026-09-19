<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function show(Request $request, string $resource)
    {
        $document = config('resources')[$resource] ?? null;
        abort_unless($document, 404);

        $path = storage_path('app/resources/'.$document['file']);
        abort_unless(is_file($path), 404);

        $headers = ['Content-Type' => $document['mime']];

        if ($request->boolean('download') || $document['format'] !== 'PDF') {
            return response()->download($path, $document['file'], $headers);
        }

        return response()->file($path, $headers);
    }
}
