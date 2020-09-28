<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Embaseindex_section extends Model
{
    protected $fillable = ['section_id', 'value','sectionvalue'];
    public $timestamps = false;
}
