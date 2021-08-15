<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameGenreModel extends Model
{
    use HasFactory;
    protected $table = "games-genres";
    protected $primaryKey = "id";
}
