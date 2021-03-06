<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use Goutte\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller
{
    protected $client;
    protected $baseURI = 'https://www.collectgbstamps.co.uk';

    /**
     * Instantiates Gouette/Client scraper.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Scrapes the issue for data.  Creates the Issue and its Stamps.
     *
     * @param integer $cgbs_issue
     *
     * @return \Illuminate\Http\RedirectResponse
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
            'release_date' => Carbon::createFromFormat('F j Y', $release_date),
            'description' => $description,
        ];

        $issue = Issue::updateOrCreate(['cgbs_issue' => $attributes['cgbs_issue']], $attributes);
        $issue_hash = substr(md5($issue->id . $issue->title), -5); // Need a consistent UUID to for folder image saving in case there are multiple issues with the same title.

        $stamp_titles = [];

        // Now save the stamps
        $crawler->filter('.stamp_entry')->each(function (Crawler $stamp, $i) use ($issue, $issue_hash, &$stamp_titles) {

            $img_url = $stamp->filter('img')->first()->extract(['src'])[0];
            $title = $stamp->filter('h3')->text();

            $description = $stamp->text();

            // Remove title from the start of the text including any left over whitespace
            if (substr($description, 0, strlen($title)) == $title) {
                $description = trim(substr($description, strlen($title)));
            }

            $denomination = null;

            // Match stamp denomination (1st 2nd) from the start of the description
            $regex = "/^(£\d+\.\d{2,}|£\d+|\d+p|1st Large|2nd Large|1st|2nd|\d+s\d+d|\d+d|\d+½?d|\d*½d|\d+s\d+½?d|\d+s|\d+½?p)/i";
            preg_match($regex, $description, $denominationMatch);

            if (isset($denominationMatch[0])) {
                $denomination = $denominationMatch[0];

                // Remove denomination from the start of the text including any left over whitespace
                if (substr($description, 0, strlen($denomination)) == $denomination) {
                    $description = trim(substr($description, strlen($denomination)));
                }
            }

            // Remove "Image Preview by Royal Mail" from description
            $description = preg_replace('/Image preview by Royal Mail/i', '', $description);
            $description = trim($description);

            // If scraper has no image then set both remote_image_url and image_url to null
            $remote_image_url = ($img_url !== '/images/noimage.jpg') ? $this->baseURI . $img_url : null;

            // This is not ideal because as there could be clashes but is unlikely.
            $stamp_hash = substr(md5($remote_image_url), -5); // Need a consistent UUID to for image saving in case there are multiple stamps with the same title.

            // Put the add one to the stamp_titles array with key of title.
            $stamp_titles[$title][] = $title;

            // There couple be multiple stamps with the same title in an issue.
            // Otherwise only one of those stamps will be added to the stamps table.  Images remain unaffected because it's a hash of the image source which is unique.
            if (count($stamp_titles[$title]) > 1) {
                $count = count($stamp_titles[$title]);
                $title = "{$title} ({$count})";
            }

            $attributes = [
                'issue_id' => $issue->id,
                'title' => $title,
                'denomination' => $denomination,
                'description' => $description,
                'remote_image_url' => $remote_image_url,
                'image' => ($remote_image_url !== null) ? $issue_hash . '_' . Str::slug($issue->title) . '/' . $stamp_hash . '_' . Str::slug($title) . '.jpg' : null,
            ];

            // Create the stamp or update if it already exists.
            // Unable to do a mass updateOrCreate to help with performance.  This should be okay as there aren't many stamps in each issue normally.
            Stamp::updateOrCreate(['issue_id' => $issue->id, 'title' => $title], $attributes);

            // If not null then download the image.
            if ($attributes['remote_image_url'] !== null && $attributes['image'] !== null) {
                // Save the image to the storage/app/public/stamps/issue/stamp
                $exists = Storage::disk('public')->exists('stamps/' . $attributes['image']);
                if (!$exists) {
                    // If image path is valid then carry on saving image.  To prevent 404 errors.
                    if (strpos(get_headers($attributes['remote_image_url'])[0], '200')) {
                        $image = file_get_contents($attributes['remote_image_url']);
                        Storage::disk('public')->put('stamps/' . $attributes['image'], $image);
                    }
                }
            }
        });

        // Convert the scraped class to an actual numerical face_value
        Artisan::queue('stamps:value', [
            'issue' => $issue->id,
        ]);

        // Extract metadata from description
        Artisan::queue('issues:metadata', [
            'issue' => $issue->id,
        ]);

        return redirect(route('catalogue.issue', ['issue' => $issue, 'slug' => $issue->slug]))
                ->withToastSuccess("Successfully imported {$issue->title}");
    }

    /**
     * Grab and save basic Issue information for each year.
     *
     * @param integer year
     *
     * @return mixed
     */
    public function issuesByYear($year = null)
    {
        if ($year == null) {
            $year = date('Y');
        }

        // Default to current year if no year is given.
        if ($year > 1800 && $year < 3000) {
            $url = $this->baseURI . '/explore/years/?year=' . $year;
            // Iterate over each stampset div and create Issue with basic information (cgbs_issue number and title)
            $this->client->request('GET', $url)->filter('.stampset h3 a')->each(function (Crawler $issue) use ($year) {
                $data = $issue->extract(['href', '_text']);
                $cgbs_issue = substr(strrchr($data[0][0], '='), 1);
                $title = trim($data[0][1]);
                $attributes = [
                    'cgbs_issue' => $cgbs_issue,
                    'title' => $title,
                    'year' => $year,
                ];
                Issue::updateOrCreate(['cgbs_issue' => $attributes['cgbs_issue']], $attributes);
            });

            return redirect(route('catalogue.year', ['year' => $year]))
                    ->withToastSuccess("Successfully imported issues for {$year}");
        } else {
            // Invalid year so abort 400 Bad Request.
            abort(404);
        }
    }

    /**
    * Returns a list of cgbs_issues from CollectGBStamps for today's year.
    *
    * @param $year
    * @return
    */
    public function cgbsIssuesByYear($year = null)
    {
        if (is_null($year)) {
            $year = date('Y');
        }

        $url = $this->baseURI . '/explore/years/?year=' . $year;

        $cgbs_issues = [];

        $cgbs_issues[] = $this->client->request('GET', $url)->filter('.stampset h3 a')->each(function (Crawler $issue) {
            $data = $issue->extract(['href']);
            return (int) substr(strrchr($data[0], '='), 1);
            //This call back is pushing all values in to index 0 of cgbs_issues.
        });

        // Return 0 index of array which is actually the array we need.
        return $cgbs_issues[0];
    }
}
