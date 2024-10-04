<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Developer extends Authenticatable implements MustVerifyEmail
{    public function getEmailForVerification()
    {
        return $this->user; 
    }
}
