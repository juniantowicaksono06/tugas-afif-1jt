<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMenu extends Model
{
    use HasFactory;

    protected $table = 'MasterMenu';

    protected $fillable = ['name', 'link', 'icon', 'hasChild', 'isParent', 'parentID'];

    public function children()
    {
        return $this->hasMany(MasterMenu::class, 'parentID');
    }
}
