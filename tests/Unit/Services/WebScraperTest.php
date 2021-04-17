<?php

namespace Tests\Unit\Services;

use App\Services\WebScraper\Scraper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group services */
class WebScraperTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * @test 
     * @dataProvider websitesProvider
    */
    public function the_scraper_can_scrape_a_page($url, $title, $image)
    {
        $this->withoutExceptionHandling();

        $scraper = new Scraper();
        
        $response = $scraper->scrape($url);

        $this->assertEquals($title, $response->title);
        $this->assertEquals($image, $response->image);
    }

    public function websitesProvider()
    {
        return [
            ['http://example.com/', 'Example Domain', null],
            ['https://beyondco.de/', 'Beyond Code', 'https://beyondco.de/img/web/homepage-invoker.png'],
            ['https://tailwindcss.com/', 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.', 'https://tailwindcss.com/_next/static/media/twitter-large-card.85c0ff9e455da585949ff0aa50981857.jpg'],
            ['https://github.com/alpinejs/alpine', 'GitHub - alpinejs/alpine: A rugged, minimal framework for composing JavaScript behavior in your markup.', 'https://opengraph.githubassets.com/7091f9d337dea3e7bbf14882f6ea81e9a719742293a11c69438f0d9c96a8e05e/alpinejs/alpine'],
            ['https://laravel.com/', 'Laravel - The PHP Framework For Web Artisans', 'https://laravel.com/img/logomark.min.svg'],
            ['https://laravel-livewire.com/', 'Livewire | Laravel Livewire', 'https://laravel-livewire.com/img/twitter.png'],
            ['https://www.nu.nl/politiek/6116137/fvd-leider-baudet-gaf-neveninkomsten-van-75000-euro-niet-op-bij-kamer.html', 'FVD-leider Baudet gaf neveninkomsten van 75.000 euro niet op bij Kamer | NU - Het laatste nieuws het eerst op NU.nl', 'https://media.nu.nl/m/v8px3u1aa0ro_wd1280.jpg/fvd-leider-baudet-gaf-neveninkomsten-van-75000-euro-niet-op-bij-kamer.jpg'],
            ['https://carbon.now.sh/', 'Carbon | Create and share beautiful images of your source code', 'https://carbon.now.sh/static/brand/banner.png'],
            ['https://www.404.org/', 'Not found', null] // website does not exist
        ];
    }
}
