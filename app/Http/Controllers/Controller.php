<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static function checkOperation(Request $request){
        $emptyId = $request->id == 0 || $request->id == "0" || empty($request->id);

        if($request->restore == 1){
            return "restore";
        }else if($emptyId && !empty($request->name)){
            return "store";
        }else if(!$emptyId && empty($request->name)){
            return "destroy";
        }else if(!$emptyId && !empty($request->name)){
            return "update";
        }else{
            return "error";
        }
    }
}
