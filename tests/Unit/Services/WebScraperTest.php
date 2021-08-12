<?php

use App\Services\WebScraper\Scraper;

beforeEach(fn () => $this->withoutExceptionHandling());

it('can scrape a page', function ($url, $title, $image) {
    $scraper = new Scraper();
    $response = $scraper->scrape($url);

    expect($response->title)->toBe($title);
    expect($response->image)->toBe($image);
})->with([
    ['http://example.com/', 'Example Domain', null],
    ['https://alpinejs.dev/start-here', 'Start Here — Alpine.js', 'https://alpinejs.dev/social.jpg'],
    ['https://tailwindcss.com/', 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.', 'https://tailwindcss.com/_next/static/media/twitter-large-card.85c0ff9e455da585949ff0aa50981857.jpg'],
    ['https://laravel.com/', 'Laravel - The PHP Framework For Web Artisans', 'https://laravel.com/img/logomark.min.svg'],
    ['https://laravel-livewire.com/', 'Livewire | Laravel Livewire', 'https://laravel-livewire.com/img/twitter.png'],
    ['https://www.nu.nl/politiek/6116137/fvd-leider-baudet-gaf-neveninkomsten-van-75000-euro-niet-op-bij-kamer.html', 'FVD-leider Baudet gaf neveninkomsten van 75.000 euro niet op bij Kamer | NU - Het laatste nieuws het eerst op NU.nl', 'https://media.nu.nl/m/v8px3u1aa0ro_wd1280.jpg/fvd-leider-baudet-gaf-neveninkomsten-van-75000-euro-niet-op-bij-kamer.jpg'],
    ['https://carbon.now.sh/', 'Carbon | Create and share beautiful images of your source code', 'https://carbon.now.sh/static/brand/banner.png'],
    ['https://www.404.org/', 'Not found', null] // website does not exist
]);
