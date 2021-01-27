<?php

namespace Tests\Unit\Services;

use App\Services\WebScraper\Scraper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
            ['https://tailwindcss.com/', 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.', 'https://tailwindcss.com/_next/static/media/sarah-dayan.a8ff3f1095a58085a82e3bb6aab12eb2.jpg'],
            ['https://github.com/alpinejs/alpine', 'GitHub - alpinejs/alpine: A rugged, minimal framework for composing JavaScript behavior in your markup.', 'https://github.githubassets.com/images/search-key-slash.svg'],
            ['https://laravel.com/', 'Laravel - The PHP Framework For Web Artisans', 'https://laravel.com/img/logomark.min.svg'],
            ['https://laravel-livewire.com/', 'Livewire | Laravel', 'https://laravel.com/img/logotype.min.svg'],
            ['https://www.404.org/', 'Not found', null] // website does not exist
        ];
    }
}
