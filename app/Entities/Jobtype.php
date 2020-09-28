<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Jobtype extends Model
{
    protected $guarded = [];
    public $primaryKey = 'jobtypeid';
    public $timestamps = false;
}
