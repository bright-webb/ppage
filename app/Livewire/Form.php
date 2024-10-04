<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\FormEntry;
use Illuminate\Support\Str;

/**
 * Class Form
 * @package App\Livewire
 */

class Form extends Component
{
    use WithFileUploads;
    public $user;
    public $template;
    public $schema;
    public $formData = [];
    public $avatar;
    public $cover;
    public $gallery = [];
    public $tempGallery = [];
    public function mount($template, $user){
        $this->template = $template;
        $this->user = $user;
        $this->schema = json_decode($template->schema, true);
       
    }

    public function handleAvatar(){
        $this->validate([
            'avatar' => 'image|max:3024',
        ]);
    }

    public function handleCover(){
        $this->validate([
            'cover' => 'image|max:3024',
        ]);
    }

    public function updatedGallery()
    {
        $this->validateOnly('gallery.*');
        foreach ($this->gallery as $photo) {
            $this->tempGallery[] = $photo;
        }
        $this->gallery = [];
        $this->emit('galleryUpdated');
    }

    public function submitForm(){
        $this->validate($this->validationRules());
        foreach($this->schema as $fieldName => $fieldType) {
            $fieldParts = explode('|', $fieldType);
            $baseType = $fieldParts[0];

            switch($baseType){
                case 'avatar':
                case 'image':
                case 'cover':
                    if ($this->avatar) {
                        $avatarPath = $this->avatar->store('avatars');
                        $this->formData['avatar'] = $avatarPath;
                    }
            
                    if ($this->cover) {
                        $coverPath = $this->cover->store('covers');
                        $this->formData['cover'] = $coverPath;
                    }
                    break;
                case 'file':
                    if(isset($this->formData[$fieldName]) && $this->formData[$fieldName] instanceof \Illuminate\Http\UploadFile){
                        $filePath = $this->formData[$fieldName]->store('uploads', 'public');
                        $this->formData[$fieldName] = $filePath;
                    }
                    break;
                case 'gallery':
                    if (!empty($this->gallery)) {
                        $galleryPaths = [];
                        foreach ($this->gallery as $image) {
                            $galleryPaths[] = $image->store('galleries');
                        }
                        $this->formData['gallery'] = $galleryPaths;
                    }
                    break;
                    default:
                    break;
            }
        }

        try{
            FormEntry::create([
                'user_id' => $this->user,
                'template_id' => $this->template->id,
                'data' => $this->formData
            ]);
            session()->flash('success', 'Form applied successfully');
        } catch(\Exception $e){
            session()->flash('error', "Something went wrong {$e->getMessage()}");
        }
        
    }

    public function render()
    {
        return view('livewire.form');
    }
    

    protected function validationRules(){
        $rules = [];
        foreach($this->schema as $fieldName => $fieldType){
            // split the field type by the pipe to extract rules
            $fieldParts = explode('|', $fieldType);

            $baseType = $fieldParts[0];
            $required = in_array('required', $fieldParts); // check if required
            $extensions = null;

            // check for file extensions
            foreach($fieldParts as $part){
                if(Str::startsWith($part, 'ext:')){
                    $extensions = str_replace('ext:', '', $part);
                }
            }

            switch($baseType){
                case 'avatar':
                case 'image':
                case 'cover':
                    $rules["formData.{$fieldName}"] = ($required ? 'required|' :''). 'file|image|max:5024';
                    break;
                case 'file':
                    $rules["formData.{$fieldName}"] = ($required ? 'required|' :''). 'file|max:5024';
                    if($extensions){
                        $rules["formData.{$fieldName}"] .= "|mimes:{$extensions}";
                    }
                    break;
                case 'gallery':
                    $rules["formData.{$fieldName}.*"] = 'file|image|max:5024';
                    break;
                case 'string':
                    $rules["formData.{$fieldName}"] = ($required ? 'required|' : '') . 'string';
                    break;
                case 'text':
                    $rules["formData.{$fieldName}"] = 'string';
                    break;
                default:
                    $rules["formData.{$fieldName}"] = 'nullable';
                    break;
            }
        }

        return $rules;
    }
}
