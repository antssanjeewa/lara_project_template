<?php

namespace App\Http\Controllers\API\Management;

use DB;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Model\Common\Address;
use App\Model\Common\Country;
use App\Model\Charity\CScType;
use App\Model\Common\District;

use App\Model\FrontOffice\Bank;
use Illuminate\Validation\Rule;

use App\Model\Common\Department;

use App\Model\FrontOffice\State;
use Spatie\Permission\Models\Role;
use App\Model\Common\HowToInteract;
use App\Model\Common\SDateCategory;
use App\Http\Controllers\Controller;
use App\Model\Common\UserNamePrefix;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\Common\SMNBroadcasting;

use App\Model\FrontOffice\InformType;
use App\Model\Common\SDateRelationType;
use App\Model\FrontOffice\Subscription;
use App\Model\FrontOffice\DonationPlace;
use Spatie\Permission\Models\Permission;
use App\Model\FrontOffice\DonationMethod;
use App\Model\FrontOffice\DonationProgram;
use App\Model\FrontOffice\DonationPlaceName;

use Illuminate\Database\Eloquent\Collection;

use App\Repositories\API\User\UserRepository;
use App\Http\Resources\Management\User\StaffUser as UserResource;
use App\Http\Resources\Management\User\LoginUser as LoginUserResource;
use App\Http\Resources\Common\User\UserSearch as UserSearchResource;
use App\Model\Common\UserNameTitle;

class StaffUserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getControler(Request $request, $var)
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
    public function postControler(Request $request, $var)
    {
        return $this->$var($request);
    }

    public function loginUser(Request $request){
        // return User::findOrFail($request->user()->id);
        return new LoginUserResource(User::findOrFail($request->user()->id));
    }

    public function index()
    {
        return UserResource::collection(User::latest()->paginate());
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
                'prefix_id' => 'max:10',
                'firstname' => 'required | max:50',
                'lastname' => 'required | max:50',
                'email' => 'nullable|string|email|max:50|unique:users',
                'nic' => 'nullable| unique:users|min:10|max:13',
                'landline' => 'nullable | min:10 | max:13',
                'mobile01' => 'nullable | min:10 | max:13',
                'mobile02' => 'nullable | min:10 | max : 13',
                'country' => 'max:30',
                'address->address01' => 'string | max:50',
                'address->address02' => 'string | max:50',
                'address->city' => 'string | max:30',
                'address->district_id' => 'integer | max:10'
            ]);

            return $this->user->create($request);
        } catch (Exception $e) {
            return response()->json(["message" => "Somthing want to wrong on the server."],  $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'prefix_id' => 'max:20',
            'firstname' => 'required | max:50',
            'lastname' => 'required | max:50',
            // 'email' => Rule::unique('users')->ignore($id),
            'email' => 'nullable | string|email|max:50|unique:users,email,'.$id,
            'landline' => 'nullable | min:10 | max:13',
            'mobile01' => 'nullable | min:10 | max:13',
            // 'mobile01' => Rule::unique('users')->ignore($id),        
            // 'nic' => Rule::unique('users')->ignore($id),
            'nic' => 'nullable| min:10 | max: 13 |unique:users,nic,'.$id,
            'mobile02' => 'nullable | min:10 | max : 13',
            'country' => 'max:30',
            'address->address01' => 'string | max:50',
            'address->address02' => 'string | max:50',
            'address->city' => 'string | max:30',
            'address->district_id' => 'integer | max:10'
        ]);

        return $this->user->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->user->delete($id);
        return response()->json(null, 204);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchquery = $request->searchquery;
        $user2 = [];
        try {

            $user1 = User::with(['address','subscriptions:id,remark_id,user_id'])->where('is_member', true)
                ->where('state',0)
                ->where(function ($query) use ($searchquery) {
                    $query->where('name', 'like', '%' . $searchquery . '%')
                        ->orWhere('name_eng', 'LIKE', '%' . $searchquery . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchquery . '%')
                        ->orWhere('mobile01', 'LIKE', '%' . $searchquery . '%')
                        ->orWhere('nic', 'LIKE', '%' . $searchquery . '%')
                        ->orWhereHas('subscriptions', function ($query2) use ($searchquery) {
                            $query2->where('remark_id', 'like', "%{$searchquery}%");
                        })
                        ->orWhereHas('address', function ($query2) use ($searchquery) {
                            $query2
                            ->where('address01', 'like', "%{$searchquery}%")
                            ->orWhere('address02', 'like', "%{$searchquery}%")
                            ->orWhere('city', 'like', "%{$searchquery}%");
                        });
                })
                ->latest()
                ->paginate();

                
            return  UserSearchResource::collection($user1);

            // return response()->json(["data" => $data]);
        } catch (Exception $e) {
            return response()->json(["message" => "Somthing want to wrong on the server."],  $e->getCode());
        }
    }


   
    /**
     * Get non Subscribe Users
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function categoriesUser(Request $request)
    {
        $category = $request->category;
        $searchquery = $request->get('query');
        $user = [];

        if($category == "Non Subscribe"){
            $user = User::where('is_member', true)->where('state',0)->doesnthave('subscriptions');
        }elseif($category == "Inactive"){
            $user = User::where('is_member', true)->where('state',1);
        }elseif($category == "පිවිතුරු පැන් පූජා"){
            $user = DonationProgram::find(1)->user()->where('state',0);
        }elseif($category == "ධර්ම දාන"){
            $user = DonationProgram::find(2)->user()->where('state',0);
        }elseif($category == "අධ්‍යාපන ශිෂ්‍යත්ව"){
            $user = DonationProgram::find(3)->user()->where('state',0);
        }elseif($category == "අභය දාන"){
            $user = DonationProgram::find(4)->user()->where('state',0);
        }elseif($category == "දායකත්ව ධර්ම දේශනා"){
            $user = DonationProgram::find(6)->user()->where('state',0);
        }elseif($category == "Top Rated"){
            // $user = User::whereHas('subscriptions')->with(['subscriptions' => function ($query){
            //     $query->first()->orderBy('unit_amount','DESC');
            // }])->has('subscriptions');
            $user = User::where('is_member', true)
            ->whereHas('subscriptions',function($query){
                $query->orderBy('subscriptions.unit_amount','DESC')
                ->where('subscriptions.unit_amount','>=',5000);
            })
            ->whereHas('donationRecords',function($query){
                $query->whereHas('monthsRecords', function ($query2) {
                    $query2->where('year','2019');
                },'>=', 3);
                // $query->where('donated_date', 'like', '2019%');
            });
            // $user = User::where('is_member', true)->whereHas('donationRecords',function($query){
            //     $query->whereHas('monthsRecords', function ($query2) {
            //         $query2->where('year','2019');
            //     },'>=', 10);
            //     // $query->where('donated_date', 'like', '2019%');
            // });

            // $user = User::where('is_member', true)->whereHas('subscriptions')->sortByDesc('subscriptions.unit_amount');
        }elseif($category == "No Record"){
            $user = User::where('is_member', true)->doesnthave('donationRecords');
        }else{
            $user = User::where('is_member', true)->where('rating','>',5);
        }

        if(strlen($searchquery) < 1){
            // dd($user->where('name', 'like', '%'.$searchquery.'%')->get());
            return  UserSearchResource::collection($user->paginate());
        }else{
            return  UserSearchResource::collection($user->where(function ($query) use ($searchquery) {
                    $query->where('name', 'like', '%' . $searchquery . '%')
                        ->orWhere('name_eng', 'LIKE', '%' . $searchquery . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchquery . '%')
                        ->orWhere('mobile01', 'LIKE', '%' . $searchquery . '%')
                        ->orWhere('nic', 'LIKE', '%' . $searchquery . '%')
                        ->orWhereHas('subscriptions', function ($query2) use ($searchquery) {
                            $query2->orderBy('remark_id')
                            ->where('remark_id', 'like', "%{$searchquery}%");
                        })
                        ->orWhereHas('address', function ($query2) use ($searchquery) {
                            $query2
                            ->where('address01', 'like', "%{$searchquery}%")
                            ->orWhere('address02', 'like', "%{$searchquery}%")
                            ->orWhere('city', 'like', "%{$searchquery}%");
                        });
                })
                ->paginate()
            );
        }
        
        // return UserResource::collection(User::where('is_member', true)->whereHas('donationRecords', function (Builder $query) {
        //     $query->where('content', 'like', 'foo%');
        // })->get() );
        // return UserResource::collection(User::where('is_member', true)->doesnthave('donationRecords')->get() );
    }
    /**
     * Get User Asserts
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function asserts()
    {
        $data = [
            'country' => Country::select('id', 'name')->get(),
            'district' => District::select('id', 'name')->get(),
            'prefix' => UserNamePrefix::select('id', 'prefix')->get(),
            'title' => UserNameTitle::select('id', 'name')->get(),
            'programs' => DonationProgram::where('state', 'active')->where('type','general')
                ->select('id', 'name')->get(),
        ];
        return response()->json(["responce" => $data], 202);
    }

    /**
     * Get User Asserts
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function profileAsserts()
    {
        $data = [
            'country' => Country::select('id', 'name')->get(),
            'district' => District::select('id', 'name')->get(),
            'prefix' => UserNamePrefix::select('id', 'prefix')->get(),
            'title' => UserNameTitle::select('id', 'name')->get(),
            'programs' => DonationProgram::where('state', 'active')->where('type','monthly')
                ->select('id', 'name')->get(),
            'places' => DonationPlace::where('state', 'active')->select('id', 'place')->get(),
            'placeNames' => DonationPlaceName::where('state', 'active')->select('id', 'name', 'donation_place_id')->get(),
            'informTypes' => InformType::where('state', 'active')->select('id', 'type_name')->get(),
            'methods' => DonationMethod::where('state', 'active')->select('id', 'method_name')->get(),
            'states' => State::where('state', 'active')->select('id', 'state_name')->get(),
            'banks' => Bank::where('state', 'active')->select('id', 'name')->get(),
            'category' => SDateCategory::where('state','active')->select('name')->get(),
            'relType' => SDateRelationType::where('state','active')->select('name')->get(),
            'broadcast' => SMNBroadcasting::where('state','active')->select('name')->get(),
            'interact' => HowToInteract::where('state','active')->select('name')->get(),            
            'type' => CScType::where('state', 'active')->select('id','name','value')->get(),

        ];
        return response()->json(["responce" => $data], 202);
    }
    /**
     * Set Password Reset
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function passwordReset(Request $request)
    {

        if ($request->newPass == $request->comfirmPass) {

            $user = User::findOrFail($request->id);
            $pass = bcrypt($request->newPass);

            $user->update(['password' => $pass]);
            $user->update(['email' => $request->email]);
            $user->remarks()->create([
                'body' => "Change Password",
                'user_id' => $request->user
            ]);
            return response()->json(["message" => "Successfully Change Your Password"]);
        }
        return response()->json(["message" => "Try Again!"]);
    }
    /**
     * User Advanced Search
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function advancedSearch(Request $request)
    {
        // $query = $request->query;
        $user = User::where('name', 'LIKE', '%' . $request->name . '%')
            ->where('title', 'LIKE', "%$request->title%")
            ->where('prefix_id', $request->prefix)
            // ->where('email', 'LIKE',"%$request->email%")
            // ->where('nic', 'LIKE', "%$request->nic%")
            ->where('mobile01', 'LIKE', "%$request->mobile%")
            ->where('register_date', 'LIKE', "%$request->register_date%")
            // ->whereHas('subscriptions', function ($query) use ($request) {
            //     $query->where('remark_id', 'like', "%{$request->remark_id}%");
            // })
            // ->whereHas('address', function ($query) use ($request) {
            //     $query->where('district_id',$request->district)
            //             ->orWhere('address01', 'like', "%{$request->address}%")
            //             ->orWhere('address02', 'like', "%{$request->address}%")
            //             ->orWhere('city', 'like', "%{$request->address}%");
            // })
            ->paginate();

        return UserResource::collection($user);
    }


  /*
    |---------------------------------------------------------------------------------------------------------
    |                                       Staff User Functions
    |---------------------------------------------------------------------------------------------------------
    |
    |                   All staff User Related funtions are written below
    |
    */
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

     /**
     * Get Staff Members List
     *
     * @return \Illuminate\Http\Response
     */
    public function staff(Request $request)
    {
        if(auth()->user()->hasRole('super-admin')){
            return StaffUserResource::collection(User::where('is_member', false)->paginate());
        }else{
            $dept =  $request->user()->department()->pluck('id');
            
            return StaffUserResource::collection(User::where('is_member', false)->where('state',0)->whereHas('department',function($query) use($dept){
                $query->whereIn('id',$dept);
            })->where('name','!=','Super Admin')->paginate());
        }
    }
    /**
     * Get Staff Members Asserts
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function staffAsserts()
    {
        $data = [
            'permission' => Permission::select('id','name')->get(),
            'department' => Department::where('state','active')->get()->pluck('name')->values(),
            'role' => Role::select('id', 'name')->get()
        ];
        return response()->json(["data" => $data], 202);
    }

    /**
     * Staff User Search
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function staffSearch(Request $request)
    {
        $searchquery = $request->searchquery;
        return StaffUserResource::collection(User::where('is_member', false)
        ->where('state',0)
        ->where(function ($query) use ($searchquery) {
            $query->where('name', 'like', '%' . $searchquery . '%')
                ->orWhere('email', 'LIKE', '%' . $searchquery . '%')
                ->orWhere('mobile01', 'LIKE', '%' . $searchquery . '%')
                ->orWhere('nic', 'LIKE', '%' . $searchquery . '%');
        })
        ->paginate());
    }
    
    /**
     * Add Direct Permission To The staff User
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function addDirectPermission(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->givePermissionTo($request->permission);
        return response()->json(["message" => "Successfully Add Permission"]);
    }
}
