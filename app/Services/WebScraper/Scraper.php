<?php

namespace App\Services\WebScraper;

use Exception;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Scraper
{
    /**
     * The url to be scraped.
     */
    public string $url;

    /**
     * The web crawler to scrape the page.
     */
    public Crawler $crawler;

    /**
     * Scrape a web page and get the title and image.
     */
    public function scrape(string $url): object
    {
        try {
            $this->url = $url;
            $this->crawler = (new Client())->request('GET', $this->url);
        } catch (Exception $e) {
            return (object) ['title' => 'Not found', 'image' => null];
        }

        return (object) [
            'title' => $this->getTitle() ?? 'Not found',
            'image' => $this->getImage(),
        ];
    }

    /**
     * Get the page's title from the <title> tag.
     */
    protected function getTitle(): ?string
    {
        return $this->crawler->filter('title')->each(fn ($node) => $node->text())[0] ?? null;
    }

    /**
     * Get the most important image of the web page.
     */
    protected function getImage(): ?string
    {
        $imageMetas = $this->crawler->filter('meta')->each(function ($node) {
            if ($node->attr('property') === 'og:image' || $node->attr('name') === 'og:image') {
                return $node->attr('content');
            }
        });

        $imageTags = $this->crawler->filter('img')->each(function ($node) {
            return $node->attr('src');
        });

        $path = collect([$imageMetas, $imageTags])->flatten()->filter()->first();

        return $this->getAbsoluteImagePath($path);
    }

    /**
     * Get the absolute path of an image from a relative path.
     */
    protected function getAbsoluteImagePath(?string $relative): ?string
    {
        if (empty($relative)) {
            return null;
        }

        if (preg_match('/https?:\/\//', $relative)) {
            return $relative;
        }

        $path = preg_replace('#/[^/]*$#', '', parse_url($this->url)['path']); // Remove non-directory element from path

        $absoluteUrl = parse_url($this->url)['host'] . $path . '/' . $relative;

        $absoluteUrl = preg_replace('/\/.?\//', '/', $absoluteUrl); // Replace '//' or '/./' with '/'

        return parse_url($this->url)['scheme'] . '://' . $absoluteUrl;
    }
}
