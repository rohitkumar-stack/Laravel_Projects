<?php

namespace App\Http\Middleware;

use Redirect;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
  //   public function handle($request, $role)
  //   {
		// if(!empty($request->user()) && $request->user()->hierarchy_id == '1' && $request->user()->role_id == '1'){
		// 	$redirect = $request->user();
		// 	//if ($redirect != 1) {
  //               // return redirect($redirect);
  //           //}
		// 	// return ($request);
		// }else{
		// 	return redirect('/')->with('permission', 'You don\'t have permission of that page!');
		// }
  //   }

    // public function handle($request, Closure $next, $role)
    // {

    //     if(!empty($request->user())){
    //         $redirect = $request->user()->hasRole($role);            
    //         $rolevalue = explode('|', $role);
    //         // print_r($role);
    //         // die('hlo');
    //         if(Auth::user()->role_id == 9 || Auth::user()->role_id == 10 || Auth::user()->role_id == 11){
    //           return Redirect::to('/');
    //         }
    //         else{
    //           return $next($request);
    //         }
    //         // if(isset($rolevalue['3']) && Auth::user()->role_id == $rolevalue['3']){
    //         //   return $next($request); 
    //         // }
    //         // elseif(Auth::user()->role_id == $rolevalue['0']){
    //         //   return $next($request); 
    //         //    // return $next($request);
    //         // }
    //         // else{
    //         //     return Redirect::to('/');
    //         // }
            
    //         // if ($redirect != 1) {
    //         //     return redirect($redirect);
    //         // }
    //         // return $next($request);
    //     }else{
    //         return redirect('/')->with('permission', 'You don\'t have permission of that page!');
    //     }
    // }

    public function handle($request, Closure $next, $role)
    {
        if(!empty($request->user())){
            $redirect = $request->user()->hasRole($role);
            if ($redirect != 1) {
                return redirect($redirect);
            }
            return $next($request);
        }else{
            return redirect('/')->with('permission', 'You don\'t have permission of that page!');
        }
    }
}
