<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MapTeacherStudent extends Model
{
    protected $table = 'map_teacher_student';
    protected $primaryKey = 'id';

    protected $DB = NULL;

    public function __construct()
    {
    	$this->DB = new DB;
    }

    public function Insert($array){

    	return $this->DB::table($this->table)->insertGetId($array);

    }

    public function GetRow($id){

    	return $this->DB::table($this->table)->find($id);

    }

    public function GetArray($array){

        return $this->DB::table($this->table)->where($array)->get();

    }

    public function GetTable(){

    	return $this->DB::table($this->table)->get();

    }

    public function DeleteRecord($id){

        return $this->DB::table($this->table)->where('id', '=', $id)->delete();

    }

    public function UpdateRecord($id, $array){

        return $this->DB::table($this->table)->where('id', $id)->update($array);

    }

	    public function GetStudent($tID, $join){
	    	return $this->DB::table('map_teacher_student')
	        ->join('student_master', function ($join) {
	            $join->on('map_teacher_student.id', '=', 'student_master.user_id')
	                 ->where('map_teacher_student.teacher_id', '=', $tID);
	        })->get();

	        //return $id;
	    }
}
