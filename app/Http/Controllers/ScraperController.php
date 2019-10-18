<?php

namespace App\Http\Controllers;

use Goutte\Client;

class ScraperController extends Controller
{
    protected $client;
    protected $baseURI = 'https://www.collectgbstamps.co.uk';

    /**
     * Description
     *  
     * @param string name
     * 
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
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
        $attributes = ['_text','href'];

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
        $attributes = ['_text','href'];

        $data = $this->client->request('GET', $url)->filter('h3 a')
                            ->extract($attributes);

        foreach ($data as $i => $stampset) {
            $strpos = strrchr($stampset[1], '=');
            $data[$i][] = substr($strpos,1);
            $data[$i][1] = $this->baseURI . $stampset[1];
        }

        return $data;
    }
}
