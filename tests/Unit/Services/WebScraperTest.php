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
            ['https://invoker.dev/', 'Invoker', 'https://invoker.dev/assets/card.png'],
            ['https://tailwindcss.com/', 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.', 'https://tailwindcss.com/_next/static/media/twitter-large-card.85c0ff9e455da585949ff0aa50981857.jpg'],
            ['https://github.com/alpinejs/alpine', 'GitHub - alpinejs/alpine: A rugged, minimal framework for composing JavaScript behavior in your markup.', 'https://avatars.githubusercontent.com/u/59030169?s=400&v=4'],
            ['https://laravel.com/', 'Laravel - The PHP Framework For Web Artisans', 'https://laravel.com/img/logomark.min.svg'],
            ['https://laravel-livewire.com/', 'Livewire | Laravel', 'https://laravel-livewire.com/img/twitter.png'],
            ['https://www.404.org/', 'Not found', null] // website does not exist
        ];
    }
}
