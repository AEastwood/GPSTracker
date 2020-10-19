<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{

    public function index(){
        return view('profile');
    }

    /*
    *   Updates Users Profile Picture
    */
    public function ChangeProfileImage(Request $request) {
        $display_images_folder = 'imgs/userprofilepics';

        request()->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        if(file_exists("$display_images_folder/" . Auth::user()->display_image)) {
            unlink("$display_images_folder/" . Auth::user()->display_image);
        }

        $rand = rand(0, getrandmax());
        $userID = Auth::id();
        $time = time();

        $imageName = "$time-" . sha1("$userID.$rand"). "." . request()->image->getClientOriginalExtension();

        request()->image->move(public_path($display_images_folder), $imageName);

        User::where('id', Auth::id())->update(['display_image' => $imageName]);

        return redirect('/profile');
    }

    /*
    *   Changes user preference to display dangerzones on the map
    *   Notifications are sent regardless
    */
    public function UpdateDangerzone($dangerzones) {
        $acceptedValues = [0, 1];

        if(!in_array($dangerzones, $acceptedValues) || strlen($dangerzones) == 0){
            return response()->json(["Status" => "406", "text" => "Unknown dangerzones value" ], 406);
        }

        User::where('id', Auth::id())->update(['dangerzones' => $dangerzones]);
        $status = ($dangerzones == 0) ? "disabled" : "enabled";

        return response()->json(["Status" => "OK", "text" => "Dangerzones have been $status", 'dangerzones' => $dangerzones], 200);
    }

    /*
    *   Changes users preferences on the MapMode
    */
    public function UpdateMapMode($mapMode){
        $acceptedValues = [0, 1];

        if(!in_array($mapMode, $acceptedValues) || strlen($mapMode) == 0){
            return response()->json(["Status" => "406", "text" => "Unknown map_mode value" ], 406);
        }

        User::where('id', Auth::id())->update(['map_mode' => $mapMode]);
        $selectedMapMode = ($mapMode == 0) ? "roadmap" : "satellite";

        return response()->json(["Status" => "OK", "text" => "Map has been set to $selectedMapMode", 'map_mode' => $mapMode], 200);
    }

    /*
    *   Changes the users preferences on the Theme of the map
    */
    public function UpdateTheme($theme){
        $acceptedValues = [0, 1];

        if(!in_array($theme, $acceptedValues) || strlen($theme) == 0){
            return response()->json(["Status" => "406", "text" => "Unknown theme value"], 406);
        }

        User::where('id', Auth::id())->update(['theme' => $theme]);
        $selectedTheme = ($theme == 0) ? "light" : "dark";

        return response()->json(["Status" => "OK", "text" => "Theme has been set to the $selectedTheme theme"], 200);
    }

    /*
    *   Changes the users update time preference
    */
    public function UpdateRefresh($refresh){

        if(!is_numeric($refresh) || strlen($refresh) == 0){
            return response()->json([ "Status" => "406", "text" => "Unknown refresh_time value" ], 406);
        }

        User::where('id', Auth::id())->update(['refreshtime' => $refresh]);

        return response()->json(["Status" => "OK","text" => "Refresh time has been set to $refresh"], 200);
    }

}
