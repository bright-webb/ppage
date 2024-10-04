<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\Developer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\FormEntry;


class PostController extends Controller
{
    public function doSignUp(Request $request){
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        // Check if email exist
        if(Developer::where('email', $email)->exists()){
            return response()->json(['message' => "There's an existing account associated with this email", "status_code" => 400]);
        }
       $user = new Developer();
       $user->name = $name;
       $user->email = $email;
       $user->password = Hash::make($password);

       DB::beginTransaction();
       try {
        $user->save();
        
        Session::put('user', $user->id);
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            parameters: [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        
        // Construct the $data array
        $data = [
            'email' => $user->email,
            'hash' => sha1($user->getEmailForVerification()), 
            'verificationUrl' => $verificationUrl, 
        ];
        Mail::to($email)->send(new VerificationMail($data));
        DB::commit();
        
        return response()->json(['message' => 'success', 'status_code' => 200]);
        
       } catch(\Exception $e){
        DB::rollBack();
        return response()->json(['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'status_code' => 500]);
       }
    }

    // Login
    public function doLogin(Request $request){
        $email = $request->email;
        $password = $request->password;
        $user = DB::table('developers')->where('email', $email)->first(); 
        if ($user && Hash::check($password, $user->password)) {
           $request->session()->put('user', $user->id);
            
            return response()->json(['status_code' => 200, 'message' => 'Login successful']);
        } else {
            return response()->json(['status_code' => 400, 'message' => 'Incorrect email address or password']);
        }
    }

    public function templateSave(Request $request){
        $user = $request->session()->get('user');
       
        $templateId = $request->templateId;
        $data = $request->except(['avatar', 'cover', 'gallery', 'file', 'array']);
        $formData = [];

        // Handle array of data
        $allRequests = $request->all();
       
        if(count($allRequests) > 0) {
           foreach($allRequests as $key => $req){
           
             if(gettype($req) == 'array'){
                // We search for strings, since we are not looking for files
                if(count($req) > 0){
                    foreach($req as $row){
                       if(gettype($row) == 'string'){
                            if($key !== 'Array'){
                                $formData[$key][] = $row;
                            }
                       }
                    }
                }
             }
           }
        }
        
      
        // Handle files
        if($request->allFiles()){
           $filesInput = $request->allFiles();
           if(count($filesInput) > 0) {
            
               foreach($filesInput as $key => $file){
                   if(is_array($file)){
                    // For some reasons, this isn't working well with the product photo, so I have to explictly check for for catalog product photo
                       if($key == 'catalog_product_photo'){
                            // Loop over this as its an array
                            foreach($file as $row){
                                $filePath = $row->store($key, 'public');
                                $formData[$key][] = $filePath;
                            }
                       }
                       else{
                        $filePath = $file[0]->store($key, 'public');
                        $formData[$key] = $filePath;
                       }
                    
                   }
               }
           }
        }
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('avatars', 'public');
            $formData['avatar'] = $avatarPath;
        }

        if($request->hasFile('cover')){
            $cover = $request->file('cover');
            $coverPath = $cover->store('covers', 'public');
            $formData['cover'] = $coverPath;
        }

        if($request->hasFile('gallery')){
            $files = $request->file('gallery');  
            $paths = [];

            foreach($files as $file){
                $paths[] = $file->store('gallery', 'public');
            }

            $formData['gallery'] = $paths;
        }
        
        $formData = array_merge($data, $formData);

        try{
            if(FormEntry::where(['user_id' => $user, 'template_id' => $templateId])->exists()){
                FormEntry::where(['user_id' => $user, 'template_id' => $templateId])->update(['data' => $formData]);
            }
            else{
                   FormEntry::create([
                'user_id' => $user,
                'template_id' => $templateId,
                'data' => $formData
            ]);
            }
         
            DB::table('users')->where('id', $user)->update(['currentTemplate' => $templateId]); // Update the user's current template
            return response()->json(['message' => 'Template applied', 'status' => 200]);
        }
         catch(\Exception $e){
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
         }
       
    }
    
}
