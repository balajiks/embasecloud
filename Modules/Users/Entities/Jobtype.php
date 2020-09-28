<?php

namespace Modules\Users\Entities;

use App\Entities\Jobtype;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Jobtype extends Model
{
    use BelongsToUser;
    
    protected $fillable = ['jobtypeid', 'jobtypename'];

    public function jobtype()
    {
        //return $this->belongsTo(Jobtype::class, 'jobtypename');
		return $query->where('jobtypeid', '=', 0);
    }
	
}
