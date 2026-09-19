<?php

use App\Models\User;

test('podium charts and downloads require authentication', function () {
    $this->get(route('podium.index'))->assertRedirect(route('login'));
    $this->get(route('podium.download', 'opus'))->assertRedirect(route('login'));
});

test('each podium card downloads its own PDF document', function () {
    $this->actingAs(User::factory()->create());
    $charts = json_decode(file_get_contents(resource_path('documents/podium/manifest.json')), true, 512, JSON_THROW_ON_ERROR);
    expect($charts)->toHaveCount(18);
    expect(array_unique(array_column($charts, 'file')))->toHaveCount(18);

    $page = $this->get(route('podium.index'))->assertOk();
    foreach ($charts as $chart) {
        $page->assertSee($chart['title'])
            ->assertSee(route('podium.download', $chart['slug']));
        $response = $this->get(route('podium.download', $chart['slug']))
            ->assertOk()
            ->assertDownload($chart['file'])
            ->assertHeader('Content-Type', 'application/pdf');
        expect($response->baseResponse->getFile()->getPathname())
            ->toBe(resource_path('documents/podium/'.$chart['file']));
        expect(file_get_contents(resource_path('documents/podium/'.$chart['file']), false, null, 0, 5))->toBe('%PDF-');
    }
});

test('unknown podium charts return not found', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('podium.download', 'missing-chart'))->assertNotFound();
});

test('the PDF catalog assigns every form page once and excludes title covers', function () {
    $charts = json_decode(file_get_contents(resource_path('documents/podium/manifest.json')), true, 512, JSON_THROW_ON_ERROR);
    $expectedRanges = [[2, 3], [5, 6], [8, 10], [12, 13], [15, 15], [17, 18], [20, 21], [23, 27], [29, 32], [34, 36], [38, 39], [41, 42], [44, 45], [47, 50], [52, 53], [55, 55], [57, 57], [59, 63]];
    $pages = [];

    foreach ($charts as $index => $chart) {
        [$first, $last] = $expectedRanges[$index];
        expect($chart['source_pages'])->toBe(range($first, $last));
        expect($chart['page_count'])->toBe($last - $first + 1);
        expect($chart['file'])->toBe($chart['slug'].'.pdf');
        $pages = array_merge($pages, $chart['source_pages']);
    }

    expect($pages)->toHaveCount(45);
    expect(array_unique($pages))->toHaveCount(45);
    expect(array_values(array_diff(range(1, 63), $pages)))
        ->toBe([1, 4, 7, 11, 14, 16, 19, 22, 28, 33, 37, 40, 43, 46, 51, 54, 56, 58]);
});
