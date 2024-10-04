<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Templates;
use App\Models\MyTemplates;
use App\Models\User;
use App\Models\Profile;
use App\Models\FormEntry;
use Illuminate\Support\Str;
use App\Models\Developer;

class HomeController extends Controller
{
    public function dashboard(Request $request){
        $id = $request->session()->get('user');
        
       $user = User::where('id', $id)->first();
       $template = Templates::where('id', $user->currentTemplate)->first();

        return view('dashboard')->with('template', $template);
    }

    public function profile(Request $request){
        $user = $request->session()->get('user');
        $data = Profile::where('userId', $user)->first();
        return view('profile')->with('data', $data);
    }

    public function newProfile(Request $request){
        return view('new-profile');
    }
    public function newCard(){
        return view('new-card');
    }

    public function templates(){
        $templates = Templates::all();
        return view('templates')->with('templates', $templates);
    }

    public function viewProfile($username, Request $request){
        
       $user = User::where('username', $username)->first();

       if(!empty($user)){
        if($user->currentTemplate === NULL){
            // user doesn't have a template yet, check if user has created a profile
            $profile = Profile::where('userId', $user->id)->first();
            if(!empty($profile)){
                // user has a profile, redirect to profile page
                // return profile view with profile data
                return view('user')->with(['data'=> $profile, 'username' => $username]);
            }else{
                if($request->session()->get('user') === $user->id){
                    // Authorized user, return new profile
                    return view('new-profile');
                } else{
                    return "You are not authorized to view this page";
                }
            }
        }
        else{
            $currentTemplate = $user->currentTemplate;
            $template = Templates::where('id', $currentTemplate)->first();
            $templatePath = $template->file_path.'index.blade.php';
            if(file_exists($templatePath)){
                $form = FormEntry::where(['user_id' => $user->id, 'template_id' => $template->id])->first();
                if(!empty($form)){
                    $catalogs = [];
                    $data = json_decode($form, true);
                    foreach($data as $row => $res){
                        if(is_array($res)){
                            // Probably the catalog
                            foreach($res as $key => $value){
                               
                                // To be super sure it's the catalog
                                if(Str::contains($key, 'catalog')){
                                    // It's the catalog
                                    $catalogs[$key] = array_values($value);  
                                }
                               
                            }
                            break;
                        }
                    }

                    $data = $data['data'];

                    if(!empty($catalogs) && isset($catalogs['catalog_product_name'])){
                        $catalogItems = [];
                        foreach ($catalogs['catalog_product_name'] as $index => $productName) {
                            $catalog = new \stdClass();
                            $catalog->product_name = $productName;
                            $catalog->product_price = $catalogs['catalog_price'][$index];
                            $catalog->product_photo = $catalogs['catalog_product_photo'][$index];
                            
                            // Add the catalog item to the array
                            $catalogItems[] = $catalog;
                        }
                        $data['catalog'] = $catalogItems;
                    }
                    
                  return view()->file($templatePath, $data);
                  
                }
            }
        }
       }
       else{
        return 'user not found';
       }
    }

    public function viewTemplate($slug){
        $data = Templates::where('slug', $slug)->first();
        return view('view-template')->with('template', $data);
    }

    public function templateForm($id){
        $template = Templates::where('id', $id)->first();
        $schema = json_decode($template->schema, true);
        return view('form')->with(['template'=> $template, 'schema' => $schema]);
    }

    public function verify($id, $hash, Request $request){
        $user = Developer::where('id', $id)->first();
        if($user){
            $query = Developer::where('id', $id)->update(['isVerified' => 1]);
            if($query){
                $request->session()->put('user', $user);
                return redirect()->to('/dashboard');
            }
            else{
                return 'error';
            }
        }
        else{
            return 'user not found';
        }
    }

    public function verifyEmail($id, $hash, Request $request){
        $user = Developer::where('id', $id)->first();
        if($user){
            $query = Developer::where('id', $id)->update(['isVerified' => 1]);
            if($query){
                return 'verified';
            }
        }
    }
}
