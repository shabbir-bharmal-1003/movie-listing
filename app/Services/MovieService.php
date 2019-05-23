<?php

namespace App\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Interfaces\MovieServiceInterface;

class MovieService implements MovieServiceInterface
{
    protected $client;
    protected $request;

    public function __construct(Request $request)
    {
        $this->client = new Client();
        $this->request = $request;
    }

    /**
     * Make a api call to third party to get result
     *
     * @return Array
     */
    public function getMovieData() {
        $page = $this->request->get("start");
        if($page == 0) {
            $page = 1;
        } else {
            $page = ($page/10) + 1;
        }
        $this->request->merge(['start' => 0]);
        $client = new Client();

        $apikey = config('services.omdb.key');
        $apiurl = config('services.omdb.url');
        $search = "game";
        $s = $this->request->get("search");
        if(!empty($s["value"])) {
            $search = $s["value"];
        }
        $res = $client->request('GET', $apiurl."?s={$search}&page=".$page."&apikey=".$apikey);
        return $res;
    }
}
