<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
 
    

    static function checkOperaion($id,$name){
        $emptyId = $id == 0 || $id == "0" || empty($id);
        
        if($emptyId && !empty($name)){
            return "store";
        }else if(!$emptyId && empty($name)){
            return "destroy";
        }else if(!$emptyId && !empty($name)){
            return "update";
        }else{
            return "error";
        }
    }
}
