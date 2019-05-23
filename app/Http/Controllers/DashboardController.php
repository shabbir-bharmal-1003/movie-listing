<?php

namespace App\Http\Controllers;

use App\Interfaces\MovieServiceInterface;
use Illuminate\Http\JsonResponse;
use DataTables;

class DashboardController extends Controller
{
    protected $movieService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getData()
    {

        try {
            $result = $this->movieService->getMovieData();
            $data = \GuzzleHttp\json_decode($result->getBody()->getContents(), true);
            if ($data["Response"] == "True") {
                return DataTables::of($data["Search"])->setTotalRecords($data["totalResults"])->make(true);
            } else {
                return DataTables::of([])->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
