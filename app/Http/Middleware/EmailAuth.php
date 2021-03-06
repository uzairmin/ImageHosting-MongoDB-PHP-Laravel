<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ConnectionDb;

class EmailAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {//Checking user email is valid or not.
        try
        {
            $email = $request->email;
            $data = NULL;
            $table = "users";
            $user = new ConnectionDb();
            $collection = $user->setConnection($table);
            $data = $collection->findOne(['email'=>$email]);
            if($data!=NULL)
            {
                return $next($request);
            }
            else
            {
                return response()->json(['message'=> "Email doesn't exist..."]);
            }
        }    
        catch(\Exception $show_error)    
        {        
            return response()->json(['Error' => $show_error->getMessage()], 500);    
        }
    }
}
