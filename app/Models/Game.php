<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

protected $table = 'board_games';

  protected $fillable = [
    'title',
    'image', 
    'description',
    'price',
    'min_players',
    'max_players',
    'duration',
    'stock',
    'category_id',
];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}