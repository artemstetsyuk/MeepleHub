<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Додали 'slug' сюди
    protected $fillable = ['name', 'slug'];

    // Зв'язок з іграми (одна категорія має багато ігор)
    public function games()
    {
        return $this->hasMany(Game::class, 'category_id');
    }
}