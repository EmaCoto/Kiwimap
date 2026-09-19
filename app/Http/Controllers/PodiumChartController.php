<?php

namespace App\Http\Controllers;

class PodiumChartController extends Controller
{
    private function charts(): array
    {
        return json_decode(file_get_contents(resource_path('documents/podium/manifest.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    public function index()
    {
        return view('podium_charts', ['charts' => $this->charts()]);
    }

    public function download(string $chart)
    {
        $document = collect($this->charts())->firstWhere('slug', $chart);
        abort_unless($document, 404);

        $path = resource_path('documents/podium/'.$document['file']);
        abort_unless(is_file($path), 404);

        return response()->download($path, $document['file'], [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
