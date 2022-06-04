<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organisation;
use App\Models\RoleType;
use App\Models\Hierarchy;
use Redirect;
use Mail;
use DB;
use Session;
use Config;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // Get Organisation By ID
    public function GetOrganisationById($parent_id,$organisation_url){        
        $organisations = DB::table($organisation_url.'.organisation')
                        ->where('parent_id',$parent_id)->where('is_del','0')
                        ->get();

        $organisation_detail = array();
        $organisation_hre = array();
        if($organisations){
            foreach ($organisations as $key => $organisation) {
                $array = (array) $organisation;
                $organisation_detail[]= $organisation->id;
                $children = $this->GetOrganisation($organisation->userid,$organisation_url);
                if ($children) {
                    $array['organisationtree'] = $children;

                    if($children["organisations"]){
                        foreach ($children["organisations"] as $child_organisations) {
                            $organisation_detail[]= $child_organisations->id;
                        }
                    }

                }
                $organisation_hre[] = $array;
            }
        }
        if(!empty($organisation_hre)){
            return array(
                "organisations" => $organisation_detail,
                "organisation_hre" => $organisation_hre
            );
        }
    }
    // Get Organisation
    public function GetOrganisation($parent_id,$organisation_url){        
        $organisations = DB::table($organisation_url.'.organisation')
                        ->where('parent_id',$parent_id)->where('is_del','0')
                        ->get();

        $organisation_detail = array();
        $organisation_hre = array();
        if($organisations){
            foreach ($organisations as $key => $organisation) {
                $array = (array) $organisation;
                $organisation_detail[]= $organisation;
                $children = $this->GetOrganisation($organisation->userid,$organisation_url);
                if ($children) {
                    $array['organisationtree'] = $children;

                    if($children["organisations"]){
                        foreach ($children["organisations"] as $child_organisations) {
                            $organisation_detail[]= $child_organisations;
                        }
                    }

                }
                $organisation_hre[] = $array;
            }
        }
        if(!empty($organisation_hre)){
            return array(
                "organisations" => $organisation_detail,
                "organisation_hre" => $organisation_hre
            );
        }
    }

    // Auto Password

    function AutoPassword( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    // super admin

    public function GetSuperAdminOrganisation($parent_id){        
        $organisations = DB::table('organisation')->where('parent_id',$parent_id)->where('is_del','0')->get();
        $organisation_detail = array();
        $organisation_hre = array();
        if($organisations){
            foreach ($organisations as $key => $organisation) {
                $array = (array) $organisation;
                $organisation_detail[]= $organisation;
                $children = $this->GetSuperAdminOrganisation($organisation->userid);
                if ($children) {
                    $array['organisationtree'] = $children;

                    if($children["organisations"]){
                        foreach ($children["organisations"] as $child_organisations) {
                            $organisation_detail[]= $child_organisations;
                        }
                    }

                }
                $organisation_hre[] = $array;
            }
        }
        if(!empty($organisation_hre)){
            return array(
                "organisations" => $organisation_detail,
                "organisation_hre" => $organisation_hre
            );
        }
    }
}
