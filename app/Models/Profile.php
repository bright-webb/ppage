<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'userId',
         'name',
        'title',
        'company',
        'email',
        'phone',
        'bio',
        'country',
        'state',
        'city',
        'facebook',
        'twitter',
        'linkedin',
        'github',
        'instagram',
        'website',
        'profilePicture'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
