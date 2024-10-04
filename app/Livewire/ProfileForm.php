<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileForm extends Component
{

    use WithFileUploads;

    public $id;
    public $user;
    public $profile;
    public $photo;
    public $firstName;
    public $lastName;
    public $title;
    public $company;
    public $email;
    public $phone;
    public $bio;
    public $country;
    public $state;
    public $city;
    public $facebook;
    public $twitter;
    public $linkedin;
    public $github;
    public $instagram;
    public $website;

    public function mount($id) {
        $this->id = $id;
        $this->user = User::find($this->id); 
        $this->profile = Profile::where('userId', $this->id)->first();
    
        if ($this->profile) {
            // Split name and assign to firstName and lastName
            $name = explode(' ', $this->profile->name);
            $this->firstName = $name[0];
            $this->lastName = isset($name[1]) ? $name[1] : ''; // Handle if last name is missing
    
            // Fill other profile fields
            $this->fill($this->profile->only([
                'userId', 'title', 'company', 'email', 'phone', 'bio', 'company', 'country', 'state', 'city', 'facebook', 'twitter', 'linkedin', 'github', 'instagram', 'website'
            ]));
        }
    }
    

    public function uploadPhoto(){
        $this->validate([
            'photo' => 'image|max:2024', 
        ]);
    }

    public function save(){
        $validatedData = $this->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2024',
        ]);

        $profileData = [
            'userId' => $this->id, 
            'name' => $this->firstName.' '.$this->lastName,
            'title' => $this->title,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'company' => $this->company,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'website' => $this->website,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
        ];

        // Handle file upload if photo exists
        if ($this->photo) {
            $photoPath = $this->photo->store('photos', 'public');
            $profileData['profilePicture'] = $photoPath;

            // Delete old profile picture if exists
            if ($this->profile && $this->profile->profilePicture) {
                Storage::disk('public')->delete($this->profile->profilePicture);
            }
        }

        // Update or create profile with the validated data
        if ($this->profile) {
            $this->profile->update($profileData);
        } else {
            Profile::create($profileData);
        }

        // Flash message to the session
        session()->flash('message', 'Profile updated successfully!');

        // Optionally, redirect after saving
        return redirect("/{$this->user->username}");
        
        
    }
    
    public function render()
    {
        return view('livewire.profile-form');
    }
}
