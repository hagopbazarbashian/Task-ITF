<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneBookItem;
use App\Http\Requests\PhoneBokkingItemRequest;
use App\Services\ExternalApiService;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;

class PhoneBookController extends Controller
{

    use HasApiTokens;

    private $externalApiService;

    public function __construct(ExternalApiService $externalApiService)
    {
        $this->externalApiService = $externalApiService;
        $this->middleware('auth:api');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $perPage = $request->input('per_page', 10); //per page: 10
            $page = $request->input('page', 1); //page: 1

            $phoneBookItems = PhoneBookItem::paginate($perPage, ['*'], 'page', $page);

            // return PhoneBookItem::paginate(10);

            return response()->json($phoneBookItems);

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhoneBokkingItemRequest $request)
    {
        try {
            // Fetch countries for validation
            $countries = $this->externalApiService->getCountries();
            // Fetch timezones for validation
            $timezones = $this->externalApiService->getTimezones();

            $phoneBookItem = PhoneBookItem::create($request->all());
            return response()->json($phoneBookItem, 201);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage()); 
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $phoneBookItem = PhoneBookItem::find($id);
            if (!$phoneBookItem) {
                return response()->json(['error' => 'Phone book item not found'], 404);
            }
            return response()->json($phoneBookItem);

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Fetch countries for validation
            $countries = $this->externalApiService->getCountries();
            // Fetch timezones for validation
            $timezones = $this->externalApiService->getTimezones();

            $phoneBookItem = PhoneBookItem::findOrFail($id);
            $phoneBookItem->update($request->all());

            return response()->json($phoneBookItem, 200);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $phoneBookItem = PhoneBookItem::findOrFail($id);
            $phoneBookItem->delete();
            return response()->json(null, 204);

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }

    }

    public function search($name)
    {
        try {
            $phoneBookItems = PhoneBookItem::where('first_name', 'like', "%$name%")
            ->orWhere('last_name', 'like', "%$name%")
            ->get();

          return response()->json($phoneBookItems);

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
        
    }
    
}
