<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Templates;
use App\Models\User;
use App\Models\FormEntry;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function getTemplates(){
        $templates = Templates::all();
        foreach($templates as $template){
            $template->thumb = Storage::url($template->thumbnail);
        }

        return response()->json(['templates' => $templates], 200);
    }

    public function getForm($id){
        $data = Templates::where('id', $id)->first();
        if($data){
            return response()->json(['data' => $data], 200);
        }else{
            return response()->json(['error' => 'Something went wrong'], 404);
        }
    }

    

    public function submit(Request $request){
        $user = User::where('email', $request->email)->first();
        $user = $user->id;
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
         
            User::where('id', $user)->update(['currentTemplate' => $templateId]); // Update the user's current template
            return response()->json(['message' => 'Template applied', 'status' => 200]);
        }
         catch(\Exception $e){
            return response()->json(['message' => 'Something went wrong ', 'more' => $e->getMessage(), 'status' => 500]);
         }
       
    }
}
