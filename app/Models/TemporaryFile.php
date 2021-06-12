<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class TemporaryFile extends Model
{
    protected $fillable = ['filename', 'folder'];
}
