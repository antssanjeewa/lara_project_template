<?php

namespace App\Http\Controllers\API\AdminBoard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Remark;
use App\Http\Resources\AdminBoard\Remarks as RemarkResource;

class RemarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function controler(Request $request, $var)
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
        return RemarkResource::collection(Remark::latest()->paginate());
    }

    public function search(Request $request)
    {
        $searchquery = $request->searchquery;
        $main = $request->main;
        $sub = $request->sub;
        $remark = "";
        $result = "";

        $remark = Remark::type($sub);

        if ($searchquery) {
            $result = $remark->where(function ($query) use ($searchquery) {
                $query->where('body', 'like', '%' . $searchquery . '%')
                    ->orWhere('created_at', 'like', '%' . $searchquery . '%')
                    ->orWhereHas('user', function ($query) use ($searchquery) {
                        $query->where('name', 'like', "%{$searchquery}%");
                    });
            })->latest()->paginate();
        } else {
            $result = $remark->latest()->paginate();
        }

        return RemarkResource::collection($result);
    }
}
