<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\NumberController as NumberControllerOrigin;
use App\Http\Requests\StoreNumberRequest;
use App\Http\Requests\UpdateNumberRequest;
use Illuminate\Http\Request;


class NumberController extends Controller
{
    protected $ctrl;
    public function __construct(NumberControllerOrigin $ctrl){
        $this->ctrl = $ctrl;
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
        $res = $this->ctrl->store($request);
        return response()->json($res, $res["code"]);

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
    public function update(UpdateNumberRequest $request, string $id)
    {
        $res = $this->ctrl->update($request, $id);
        return response()->json($res, $res["code"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = $this->ctrl->destroy($id);
        return response()->json($res, $res["code"]);
    }
}
