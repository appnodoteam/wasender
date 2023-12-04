<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\NumberController as NumberControllerOrigin;
use App\Http\Requests\StoreNumberRequest;
use Illuminate\Http\Request;

class NumberController extends Controller
{
    public $ctrl;
    public function __construct(){
        $this->ctrl = new NumberControllerOrigin();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->ctrl->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNumberRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
