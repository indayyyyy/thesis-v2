<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'start',
        'end',
        'status',
        'title',
        'time_type',
        'case_category_id'
    ];
    protected $dates = [ 'deleted_at' ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function case_categories()
    {
        return $this->hasMany(CaseCategory::class,'case_category_id','id');
    }
}
