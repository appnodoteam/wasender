<?php

namespace App\Http\Controllers\V1;

use App\Helpers\Sender;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNumberRequest;
use App\Http\Requests\UpdateNumberRequest;
use App\Jobs\SendMessageTextJob;
use App\Models\V1\Number;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Number::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNumberRequest $request)
    {


        SendMessageTextJob::dispatch($request->number, $request->destination, $request->message);

        return response()->json([
            'message' => 'Message added to queue'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Number $number)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNumberRequest $request, Number $number)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Number $number)
    {
        //
    }
}
