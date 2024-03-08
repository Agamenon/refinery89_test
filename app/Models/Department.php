<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_department_id'
    ];

    public function parentDepartment(){
        return $this->belongsTo(Department::class, 'parent_department_id');
    }

    public function childDepartments(){
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
