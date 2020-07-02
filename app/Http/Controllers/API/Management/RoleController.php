<?php

namespace App\Http\Controllers\API\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

use App\Http\Resources\Management\Role as RolenResource;

class RoleController extends Controller
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
        if( auth()->user()->can('add management') ){
            return RolenResource::collection(Role::paginate(100));
        }else{
            $role = Role::paginate(100);

            $filtered = $role->filter(function ($value) {
                return ($value->name != 'super-admin' && $value->name != 'advisor');
            });
            
            return RolenResource::collection($filtered);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['guard_name' => 'web','name' => strtolower($request->name)]);
        $role->syncPermissions($request->permissions);

        // $role->addNewRemark();
        
        return response()->json(["message" => "Add Role Successfully", "responce" => $role], 201);
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
        $role = Role::findOrFail($id);

        $role->syncPermissions($request->permissions);

        // Create Remark when Update
        // $original = clone $role;
        // $remark = $request->remark;
        unset($request['permissions']);
        unset($request['remark']);
        unset($request['user']);
        
        $role->update($request->all());
        // $role->updateRemark($original,$remark);

        return response()->json(["message" => "Update Role Successfully", "responce" => $role], 201);
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
}
