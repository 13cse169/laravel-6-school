<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    protected $fillable = ['school_id', 'name', 'phone', 'email', 'address', 'profile', 'created_at'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public static function getlist($like, $column, $order, $offset, $limit)
    {
        $fillable = ['name', 'phone', 'email', 'address', 'created_at'];

        $query = Teacher::join('schools', 'schools.id', '=', 'teachers.school_id');
        $query->select('teachers.*', 'schools.name AS schoolName');
        
        if($like)
        {
            $query->where('schools.name', 'like', '%'.$like.'%');
            foreach ($fillable as $key => $value)
                $query->orWhere('teachers.'.$value, 'like', '%'.$like.'%');
        }
        if($limit) $query->offset($offset)->limit($limit);

        return $query->orderBy($column, $order)->get();
    }

    public static function excelData($like, $column, $order)
    {
        $fillable = ['name', 'phone', 'email', 'created_at'];

        $query = School::select('name', 'phone', 'email', 'address', 'created_at');
        $query = Teacher::join('schools', 'schools.id', '=', 'teachers.school_id');
        $query->select('schools.name AS schoolName', 'teachers.name', 'teachers.phone', 'teachers.email', 'teachers.address', 'teachers.created_at');

        if($like)
        {
            $query->where('schools.name', 'like', '%'.$like.'%');
            foreach ($fillable as $key => $value)
                $query->orWhere('teachers.'.$value, 'like', '%'.$like.'%');
        }

        return $query->orderBy($column, $order)->get();
    }

    public static function whereLike($like)
    {
        $fillable = ['name', 'phone', 'email', 'created_at'];

        $query = Teacher::join('schools', 'schools.id', '=', 'teachers.school_id');
        $query->select('teachers.*', 'schools.name AS schoolName');
        
        $query->where('schools.name', 'like', '%'.$like.'%');
        
        foreach ($fillable as $key => $value)
            $query->orWhere('teachers.'.$value, 'like', '%'.$like.'%');

        return $query->get();
    }

    public static function deleteRecord($id)
    {
        return Teacher::destroy($id);
    }
}
