<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    // pobieranie linka do zdjęcia - w widoku dzięki getPhotoAtribute pobieramy zdjęcie $article->photo
    public function getPhotoAttribute()
    {
        return Str::startsWith($this->image, 'http') ? $this->image : Storage::url($this->image);
        //return Storage::url($this->image);
    }
}
