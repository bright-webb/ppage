<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ApiKey extends Component
{
    public $apiKey;
    public $user;

    public function mount($user){
        $this->user = $user;
        $query = DB::table('api_keys')->where('user_id', $this->user);
        
        if($query->exists()){
            $this->apiKey = $query->first()->apiKey;
        }
        else{
            $this->apiKey = null;
        }
    }

    public function generateApiKey(){
        $apiKey = bin2hex(random_bytes(16));
        DB::table('api_keys')->updateOrInsert([
            'user_id' => $this->user,
            'apiKey' => $apiKey
        ]);

        $this->apiKey = $apiKey;

    }
    public function render()
    {
        return view('livewire.api-key');
    }
}
