<?php

namespace App\Services\WebScraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Scraper
{
    public string $url;

    public Crawler $crawler;

    public function scrape(string $url): object
    {
        $this->url = $url;
        $client = new Client();

        try {
            $this->crawler = $client->request('GET', $url);
        } catch (\Exception $e) {
            return (object) ['title' => 'Not found', 'image' => null];
        }

        return (object) [
            'title' => $this->getTitle(),
            'image' => $this->getImage()
        ];
    }

    protected function getTitle(): string
    {
        return $this->crawler->filter('title')->each(function ($node) {
            return $node->text();
        })[0] ?? 'Not found';
    }

    protected function getImage(): string|null
    {
        if ($image = $this->getImageFromMetaProperty()) {
            return $image;
        }

        if ($image = $this->getImageFromMetaName()) {
            return $image;
        }

        return $this->getImageFromTag();
    }

    protected function getImageFromMetaProperty(): string|null
    {
        return $this->getAbsoluteImagePath(collect($this->crawler->filter('meta')->each(function ($node) {
            if ($node->attr('property') == 'og:image') {
                return $node->attr('content');
            }
        }))->filter()->flatten()[0] ?? null, $this->url) ?? null;
    }

    protected function getImageFromMetaName(): string|null
    {
        return $this->getAbsoluteImagePath(collect($this->crawler->filter('meta')->each(function ($node) {
            if ($node->attr('name') == 'og:image') {
                return $node->attr('content');
            }
        }))->filter()->flatten()[0] ?? null, $this->url) ?? null;
    }

    protected function getImageFromTag(): string|null
    {
        return $this->crawler->filter('img')->each(function ($node) {
            return $this->getAbsoluteImagePath($node->attr('src'), $this->url);
        })[0] ?? null;
    }

    protected function getAbsoluteImagePath($relative, $host): string|null
    {
        if (empty($relative)) {
            return null;
        }

        // return if already absolute URL
        if (parse_url($relative, PHP_URL_SCHEME) != '') {
            return $relative;
        }

        // queries and anchors
        if (substr($relative, 0) == '#' || substr($relative, 0) == '?') {
            return $host . $relative;
        }

        // parse host URL and convert to local variables: $scheme, $host, $path
        extract(parse_url($host));

        // remove non-directory element from path
        $path = preg_replace('#/[^/]*$#', '', $path);

        // destroy path if relative url points to root
        if (substr($relative, 0) == '/') {
            $path = '';
        }

        // dirty absolute URL
        $abs = $host . $path . '/' . $relative;

        // replace '//' or '/./' or '/foo/../' with '/'
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for ($n = 1; $n > 0; $abs = preg_replace($re, '/', $abs, -1, $n)) {
        }

        // absolute URL is ready!
        return $scheme . '://' . $abs;
    }
}
