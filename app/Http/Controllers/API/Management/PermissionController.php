<?php

namespace App\Http\Controllers\API\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

use App\Http\Resources\Management\Permission as PermissionResource;

class PermissionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function controler(Request $request, $var)
    {
        if(is_numeric($var)){
            return $this->show($var);
        }else{
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
        return PermissionResource::collection(Permission::latest('id')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create(['guard_name' => 'web','name' => $request->name]);

        // $permission->addNewRemark();

        return response()->json(["message"=>"Add Permission Successfully","responce"=>$permission],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $permission = Permission::findOrFail($id);
        // $original = clone $permission;
        // $remark = $request->remark;
        unset($request['remark']);
        unset($request['user']);

        $permission->update($request->all());
        // Create Remark when Update
        // $permission->updateRemark($original,$remark);

        return response()->json(["message" => "Update Permission Successfully", "responce" => $permission], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Search Item from storage.
     *
     * @param  String
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchquery = $request->searchquery;

        $result = Permission::where('name', 'like', '%' . $searchquery . '%')
            ->paginate();


        return PermissionResource::collection($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return PermissionResource::collection(Permission::all());
    }
}
