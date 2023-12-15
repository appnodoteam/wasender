<?php

namespace App\Http\Controllers\V1;

use App\Helpers\Sender;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNumberRequest;
use App\Http\Requests\UpdateNumberRequest;
use App\Jobs\SendMessageTextJob;
use App\Models\V1\Number;
use Illuminate\Support\Facades\DB;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->numbers()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNumberRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = auth()->user();
            $user->numbers()->create($request->validated());
        } catch (\Exception $e){
            DB::rollBack();
            return array(
                "message" => "Error al guardar el número",
                "code" => 400,
                "error" => $e->getCode() == 23000 ? "El número ya existe" : $e->getMessage()
            );
        }
        DB::commit();
        return array(
            "message" => "Número guardado correctamente",
            "code" => 201
        );

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
    public function update(UpdateNumberRequest $request, $number)
    {
        $user = auth()->user();
        DB::beginTransaction();
        try{
            $numberResult = $user->numbers()->findOrfail($number);
            $numberResult->update($request->validated());
        } catch (\Exception $e){
            DB::rollBack();
            return array(
                "message" => "Error al actualizar el número",
                "code" => 400,
                "error" => $e->getCode() == 23000 ? "El número ya existe" : $e->getMessage()
            );
        }
        DB::commit();
        return array(
            "message" => "Número actualizado correctamente",
            "code" => 200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($number)
    {
        $user = auth()->user();
        DB::beginTransaction();
        try{
            $numberResult = $user->numbers()->findOrfail($number);
            $numberResult->delete();
        } catch (\Exception $e){
            DB::rollBack();
            return array(
                "message" => "Error al eliminar el número",
                "code" => 400,
                "error" => $e->getMessage()
            );
        }
        DB::commit();
        return array(
            "message" => "Número eliminado correctamente",
            "code" => 200
        );
    }
}
