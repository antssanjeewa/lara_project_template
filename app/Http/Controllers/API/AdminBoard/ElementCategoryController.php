<?php

namespace App\Http\Controllers\API\AdminBoard;

use Illuminate\Http\Request;
use App\Model\ElementCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminBoard\ElementCategory as ElementCategoryResource;

class ElementCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contelement_categoryr(Request $request, $var)
    {
        if (is_numeric($var)) {
            return $this->show($var);
        } else {
            return $this->$var($request);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ElementCategoryResource::collection(ElementCategory::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
            ]);

            //create item
            $item = ElementCategory::create($request->all());
            //add remark
            $item->addRemark();

            return response()->json(["message" => "Update Element Category Successfully"], 201);
        } catch (Exception $e) {
            return response()->json(["message" => "Somthing want to wrong on the server."],  $e->getCode());
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
        return new ElementCategoryResource(ElementCategory::findOrFail($id));
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
            $item = ElementCategory::findOrFail($id);

            $original = clone $item;

            $request->validate([
                'name' => 'required|string|max:50',
                'state' => 'required|string|max:50',
                'remark' => 'required|string|max:50',
            ]);

            //update item
            $item->update($request->all());
            //add remark
            $item->updateRemark($original, $request->remark);

            return response()->json(["message" => "Update Element Category Successfully"], 201);
        } catch (Exception $e) {
            return response()->json(["message" => "Somthing want to wrong on the server."],  $e->getCode());
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
        $item = ElementCategory::findOrFail($id);
        $item->delete();
        $item->deleteRemark();
        return response()->json(null, 204);
    }
}
