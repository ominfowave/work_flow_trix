<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GenerateLink;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index(){
        $link = GenerateLink::where("created_at",'>=', Carbon::now()->subDay())->get();

        return view('setting.index', compact('link'));
    }

    public function generateLink(Request $request){
        if($request->moduletype !== ""){
            $link = GenerateLink::where("link_type", $request->moduletype)->where("created_at",'>=', Carbon::now()->subDay())->exists();

            if(!$link){
                $generateLinkData = [
                    'link' => uniqid(),
                    'link_type' => $request->moduletype
                ];
                $generateLink = GenerateLink::create($generateLinkData);

                $link = $generateLink->link;

                $url = route('register.' . $request->moduletype, $link);

                return response()->json([
                    'link' => $url
                ]);
            }
        }

    }
    
}
