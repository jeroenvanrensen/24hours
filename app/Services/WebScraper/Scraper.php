<?php

namespace App\Services\WebScraper;

use Exception;
use Goutte\Client;

class Scraper
{
    public $crawler;

    public function scrape(string $url): object
    {
        $client = new Client();

        try {
            $this->crawler = $client->request('GET', $url);
        } catch (Exception $e) {
            return (object) ['title' => 'Not found'];
        }      

        return (object) [
            'title' => $this->getTitle()
        ];
    }

    protected function getTitle(): string
    {
        return $this->crawler->filter('title')->each(function ($node) {
            return $node->text();
        })[0] ?? 'Not found';
    }
}
