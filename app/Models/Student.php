<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    public static function Insert($array){
    	return DB::table('student_master')->insertGetId($array);
    }

    public static function GetRow($id){
    	return DB::table('student_master')->find($id);
    }

    public static function GetArray($array){
        return DB::table('student_master')->where($array)->get();
    }

    public static function GetStudent($offset, $limit){
        //return DB::table('student_master')->get();
        $sql = "SELECT sm.*, scl.name AS sclName FROM student_master
                    AS sm LEFT JOIN school_master AS scl
                        ON sm.school_id = scl.id LIMIT $offset, $limit";

        return DB::select($sql);
    }

    /* public function DeleteRecord($id){
        return DB::table('student_master')->where('id', '=', $id)->delete();
    } */

    /* public function UpdateRecord($id, $array){
        return DB::table('student_master')->where('id', $id)->update($array);
    } */
}
