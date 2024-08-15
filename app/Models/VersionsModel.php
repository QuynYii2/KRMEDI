<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionsModel extends Model
{
    use HasFactory;
    protected $table='versions';
    protected $fillable=[
        'version_current',
        'version_update',
        'need_update',
        'note_update',
        'type'
    ];
}
