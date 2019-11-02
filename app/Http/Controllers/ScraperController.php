<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller
{
    protected $client;
    protected $baseURI = 'https://www.collectgbstamps.co.uk';

    /**
     * Instantiates Gouette/Client scraper.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Scrapes the issue for data.  Creates the Issue and its Stamps.
     *
     * @param integer cgbs_issue
     *
     * @return redirect
     */
    public function issue($cgbs_issue)
    {
        $url = $this->baseURI . '/explore/issues/?issue=' . $cgbs_issue;

        $crawler = $this->client->request('GET', $url)->filter('.issue_entry .col-sm-8');

        $title = $crawler->filter('h1')->first()->text();
        $year = (int) substr($crawler->filter('strong')->first()->text(), 0, 4);
        $text_nodes = $crawler->filterXPath('//text()');
        $description = '';

        foreach ($text_nodes as $key => $node) {
            $tc = $node->textContent;
            if ($tc == 'Stamps') {
                break;
            } //Description only goes up to "Stamps".

            if ($key === 0) {
                continue;
            } //Skip the first one which is the title.
            if ($tc === "\r") {
                continue;
            } //Ignore blank lines.
            if ($tc == $year . "\r") {
                continue;
            } //Ignore the year which is the strong tag.

            if (substr($tc, 0, 2) == ' (') {
                preg_match('#\((.*?)\)#', $tc, $match);
                $release_date = $match[1];
                continue;
            };

            $description .= $tc;
        }

        $description = trim($description, "\r");

        $attributes = [
            'cgbs_issue' => $cgbs_issue,
            'title' => $title,
            'year' => $year,
            'release_date' => date('Y-m-d', strtotime($release_date)),
            'description' => $description,
        ];

        $issue = Issue::updateOrCreate(['cgbs_issue' => $attributes['cgbs_issue']], $attributes);

        // Now save the stamps
        $crawler->filter('.stamp_entry')->each(function (Crawler $stamp, $i) use ($issue) {
            $image_url = $this->baseURI . $stamp->filter('a')->first()->extract('href')[0];
            $title = $stamp->filter('h3')->text();
            $description = trim(str_replace($title, '', $stamp->text()));
            $description = str_replace('<br>', '', $description);

            $attributes = [
                'issue_id' => $issue->id,
                'title' => $title,
                'description' => $description,
                'image_url' => $image_url,
            ];

            Stamp::updateOrCreate(['issue_id' => $issue->id, 'title' => $title], $attributes);
        });

        return redirect('/');
    }

    /**
     * Grab and save basic Issue information for each year.
     *  
     * @param integer year
     * 
     * @return void
     */
    public function issuesByYear($year = 2019)
    {
        // Default to 2019 if no year is given.
        if ($year > 1830 && $year < 3000) {
            $url = $this->baseURI . '/explore/years/?year=' . $year;
            // Iterate over each stampset div and create Issue with basic information (cgbs_issue number and title)
            $this->client->request('GET', $url)->filter('.stampset h3 a')->each(function (Crawler $issue) use ($year) {
                $data = $issue->extract(['href', '_text']);
                $cgbs_issue = substr(strrchr($data[0][0], "="), 1);
                $title = trim($data[0][1]);
                $attributes = [
                    'cgbs_issue' => $cgbs_issue,
                    'title' => $title,
                    'year' => $year,
                ];
                Issue::updateOrCreate(['cgbs_issue' => $attributes['cgbs_issue']], $attributes);
            });
        } else {
            // Invalid year so abort 400 Bad Request.
            abort(404);
        }
    }

    /**
     * Show the profile for the given user.
     * @return View
     */
    public function show($year = 2019)
    {
        $year = (int)$year;
        if (is_int($year) && $year > 1830 && $year < 3000) {
            $url = $this->baseURI . '/explore/years/?year=' . $year;
            $stampset = $this->getStampSet($url);
            dd($stampset);
        } else {
            dd('Please provide a valid year.');
        }
    }

    /**
     * Returns a list of years from the stamp collection website.
     *
     * @return array
     */
    public function getYears()
    {
        $attributes = ['_text', 'href'];

        $years = $this->client->request('GET', $this->baseURI)
                            ->filter('.nav_section')->eq(2)->filter('a')
                            ->extract($attributes);

        return $years;
    }

    /**
     * Get each StampSet for the year
     *
     * @param string url
     *
     * @return array
     */
    public function getStampSet($url)
    {
        $attributes = ['_text', 'href'];

        $data = $this->client->request('GET', $url)->filter('h3 a')
                            ->extract($attributes);

        foreach ($data as $i => $stampset) {
            $strpos = strrchr($stampset[1], '=');
            $data[$i][] = substr($strpos, 1);
            $data[$i][1] = $this->baseURI . $stampset[1];
        }

        return $data;
    }
}
