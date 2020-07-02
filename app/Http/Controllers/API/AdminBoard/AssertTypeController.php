<?php

namespace App\Http\Controllers\API\AdminBoard;

use App\Model\AssertType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminBoard\AssertType as AssertTypeResource;

class AssertTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AssertTypeResource::collection(AssertType::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\AssertType  $assertType
     * @return \Illuminate\Http\Response
     */
    public function show(AssertType $assertType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AssertType  $assertType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssertType $assertType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AssertType  $assertType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssertType $assertType)
    {
        //
    }
}
