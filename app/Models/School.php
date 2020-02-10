<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address', 'logo', 'created_at'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public static function getlist($like, $column, $order, $offset, $limit)
    {
        $fillable = ['name', 'phone', 'email', 'address', 'created_at'];

        $query = School::orderBy($column, $order);

        if($like)
        {
            $query->where('name', 'like', '%'.$like.'%');
            foreach ($fillable as $key => $value){
                $query->orWhere($value, 'like', '%'.$like.'%');
            }
        }
        if($limit) $query->offset($offset)->limit($limit);

        return $query->get();
    }

    public static function excelData($like, $column, $order)
    {
        $fillable = ['name', 'phone', 'email', 'address', 'created_at'];

        $query = School::select('name', 'phone', 'email', 'address', 'created_at')->orderBy($column, $order);

        if($like)
        {
            $query->where('name', 'like', '%'.$like.'%');
            foreach ($fillable as $key => $value)
                $query->orWhere($value, 'like', '%'.$like.'%');
        }

        return $query->get();
    }

    public static function whereLike($like)
    {
        $fillable = ['name', 'phone', 'email', 'address', 'created_at'];

        $query = School::where('name', 'like', '%'.$like.'%');
        
        foreach ($fillable as $key => $value)
            $query->orWhere($value, 'like', '%'.$like.'%');

        return $query->get();
    }

    public static function deleteRecord($id)
    {
        return School::destroy($id);
    }

}
/* 
    @foreach ($schools as $school)
        <h3>{{ $school->name }}</h3>
        <ul>
            @foreach ($school->teachers as $teacher)
                <li>{{ $teacher->name }}</li>
            @endforeach
        </ul>
    @endforeach
 */