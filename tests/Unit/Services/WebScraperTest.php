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
    public function the_scraper_can_scrape_a_page($url, $title)
    {
        $this->withoutExceptionHandling();

        $scraper = new Scraper();
        
        $response = $scraper->scrape($url);

        $this->assertEquals($title, $response->title);
    }

    /** @test */
    public function the_scraper_can_scrape_a_page_without_a_title_tag()
    {
        $this->withoutExceptionHandling();

        $url = config('app.url') . '/tests/test.html';

        $scraper = new Scraper();
        
        $response = $scraper->scrape($url);

        $this->assertEquals('Not found', $response->title);
    }

    public function websitesProvider()
    {
        return [
            ['http://example.com/', 'Example Domain'],
            ['https://tailwindcss.com/', 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.'],
            ['https://github.com/alpinejs/alpine', 'GitHub - alpinejs/alpine: A rugged, minimal framework for composing JavaScript behavior in your markup.'],
            ['https://laravel.com/', 'Laravel - The PHP Framework For Web Artisans'],
            ['https://laravel-livewire.com/', 'Livewire | Laravel'],
            ['https://www.404.org/', 'Not found'] // website does not exist
        ];
    }
}
