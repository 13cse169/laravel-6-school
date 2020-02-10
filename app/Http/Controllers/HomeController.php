<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\MapTeacherStudent;

use File;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $School  = NULL;
    protected $Teacher = NULL;
    protected $Student = NULL;
    protected $MapTeachStud = NULL;

    public function __construct(){

        $this->middleware('auth');

        $this->School  = new School();
        $this->Teacher = new Teacher();
        $this->Student = new Student();
        $this->MapTeachStud = new MapTeacherStudent();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('layouts.app');
    }

    public function schoolAdd(Request $req){

        if ($req->isMethod('POST')) {

            $myArray = [
                'name'    => $req->name,
                'phone'   => $req->phone,
                'email'   => $req->email,
                'address' => $req->address,
            ];

            $id = $this->School->Insert($myArray);

            return redirect('/school/detail/'.$id);

        } else {

            return view('school.school-list', array('scList' => DB::table('school_master')->get()));
        }
    }

    public function schoolView(Request $req){

        if ($req->isMethod('POST')) {

            $myArray = [
                'name'    => $req->name,
                'phone'   => $req->phone,
                'email'   => $req->email,
                'address' => $req->address,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->School->UpdateRecord($req->id, $myArray);

            return redirect('/school/detail/'.$req->id);

        } else {

            $Data = [
                'School'  => $this->School->GetRow($req->id),
                'Teacher' => $this->Teacher->GetArray(array('school_id' => $req->id)),
                'Student' => $this->Student->GetArray(array('school_id' => $req->id))
            ];

            return view('/school.school-detail', $Data);
        }

    }

    public function teacherAdd(Request $req){

        if ($req->isMethod('POST')) {

            $myArray = [
                'name'    => $req->name,
                'phone'   => $req->phone,
                'email'   => $req->email,
                'address' => $req->address,
                'school_id' => $req->school_id
            ];

            $id = $this->Teacher->Insert($myArray);

            return redirect('/teacher/detail/'.$id);

        } else {

            $Data = [
                'Teacher' => $this->Teacher->GetTable(),
                'School'  => $this->School->GetTable(),
                'sID'     => (isset($req->id)) ? $req->id : ''
            ];

            return view('teacher.teacher-list', $Data);
        }
    }

    public function teacherView(Request $req){

        if ($req->isMethod('POST')) {

            $myArray = [
                'name'    => $req->name,
                'phone'   => $req->phone,
                'email'   => $req->email,
                'address' => $req->address,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->Teacher->UpdateRecord($req->id, $myArray);

            return redirect('/teacher/detail/'.$req->id);

        } else {

            $Data = [
                'Teacher'  => $this->Teacher->GetRow($req->id),
            ];
            $Student = array();
            $tmp = $this->MapTeachStud->GetArray(array('teacher_id' => $req->id));
            foreach ($tmp as $key => $value) $Student[] = $this->Student->GetRow($value->student_id);

            $Data['Student'] = $Student;

            return view('/teacher.teacher-detail', $Data);
        }

    }

    public function studentAdd(Request $req){

        if ($req->isMethod('POST')) {

            $studArray = [
                'school_id' => $req->school_id,
                'name'      => $req->name,
                'phone'     => $req->phone,
                'email'     => $req->email,
                'gender'    => $req->gender,
                'language'  => implode(',', $req->language),
                'address'   => $req->address
            ];

            $imgPath = 'assets/profile/';
            if (!file_exists($imgPath)) File::makeDirectory($imgPath, $mode = 0777, true, true);

            $tmp = explode('.', $_FILES['profile']['name']);
            $imgName = date('Ymd-His').'.'.end($tmp);

            if (move_uploaded_file($_FILES['profile']['tmp_name'], $imgPath.$imgName))
                $studArray['profile'] = $imgName;

            $sID = $this->Student->Insert($studArray);

            foreach ($req->teacher_id as $key => $value){
                //$teachArray[] = array('teacher_id' => $value, 'student_id' => $sID);
                $this->MapTeachStud->Insert(array('teacher_id' => $value, 'student_id' => $sID));
            }

            return redirect('/student');

        } else {

            $Data = [
                'School'  => DB::table('school_master')->get(),
                'Student' => DB::table('student_master')->paginate(2),
                'totalPage' => round(DB::table('student_master')->count() / 2)
            ];

            if(isset($req->id)) {
                $Teacher = $this->Teacher->GetRow($req->id);

                $Data['Teacher'] = $Teacher;
                $Data['sID']     = $Teacher->school_id;
                $Data['TeacherList'] = $this->Teacher->GetArray(array('school_id' => $Teacher->school_id));

            } else $Data['sID'] = '';

            return view('student.student-list', $Data);
        }
    }

    public function studentView(Request $req){

        if ($req->isMethod('POST')) {

            print_r($req->input());

        } else {

            $Data = [
                'School'  => $this->School->GetTable(),
                'Student' => $this->Student->GetRow($req->id)
            ];
            $Data['Teacher'] = $this->Teacher->GetArray(array('school_id' => $Data['Student']->school_id));

            $mapTeach = array();
            $tmp = $this->MapTeachStud->GetArray(array('student_id' => $req->id));
            foreach ($tmp as $key => $value) $mapTeach[] = $value->teacher_id;
            $Data['mapTeach'] = $mapTeach;

            return view('student.student-detail', $Data);
        }

    }

    public function getTeacher(Request $req){

        $Teacher = $this->Teacher->GetArray(array('school_id' => $req->sID));

        $Data = '';

        if (count($Teacher)) {
            foreach ($Teacher as $key => $value) {
                $Data .= '<option value="'.$value->id.'" >'.$value->name.'</option>';
            }
        } else $Data = '<option value="" disabled="true">No Data Found...</option>';

        return json_encode($Data);
    }

    public function removeData(Request $res){

        DB::table($res->table)->where('id', '=', $res->id)->delete();

        switch ($res->table) {
            case 'student_master':
                DB::table('map_teacher_student')->where('student_id', '=', $res->id)->delete();
                break;

            case 'teacher_master':
                DB::table('map_teacher_student')->where('teacher_id', '=', $res->id)->delete();
                break;

            default:
                DB::table('student_master')->where('school_id', '=', $res->id)->delete();
                DB::table('teacher_master')->where('school_id', '=', $res->id)->delete();
                break;
        }

        return json_encode('Done');

    }

    public function getStudent(Request $res){

        if($res->studSchool && $res->studName) {
            $Res = DB::table('student_master')->where('school_id', $res->studSchool)->where('name', 'like', "%$res->studName%")->offset(0)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->where('school_id', $res->studSchool)->where('name', 'like', "%$res->studName%")->count() / 2);
        } else if($res->studName) {
            $Res = DB::table('student_master')->where('name', 'like', "%$res->studName%")->offset(0)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->where('name', 'like', "%$res->studName%")->count() / 2);
        } else {
            $Res = DB::table('student_master')->where('school_id', $res->studSchool)->offset(0)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->where('school_id', $res->studSchool)->count() / 2);
        }

        return $this->studentTablePage($Res, $totalPage, $active = 1);

    }

    public function getStudentPage(Request $res){

        switch ($res->pNo) {
            case 'Previous':
                $OffSet = (($res->cNo - 2) * 2);
                $active = ($res->cNo - 1);
                break;

            case 'Next':
                $OffSet = ($res->cNo * 2);
                $active = ($res->cNo + 1);
                break;

            default:
                $OffSet = (($res->pNo - 1) * 2);
                $active = $res->pNo;
                break;
        }

        if($res->studSchool && $res->studName) {
            $Res = DB::table('student_master')->where('school_id', $res->studSchool)->where('name', 'like', "%$res->studName%")->offset($OffSet)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->where('school_id', $res->studSchool)->where('name', 'like', "%$res->studName%")->count() / 2);
        } else if($res->studName) {
            $Res = DB::table('student_master')->where('name', 'like', "%$res->studName%")->offset($OffSet)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->where('name', 'like', "%$res->studName%")->count() / 2);
        } else if($res->studSchool) {
            $Res = DB::table('student_master')->where('school_id', $res->studSchool)->offset($OffSet)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->where('school_id', $res->studSchool)->count() / 2);
        } else {
            $Res = DB::table('student_master')->offset($OffSet)->limit(2)->get();
            $totalPage = round(DB::table('student_master')->count() / 2);
        }

        return $this->studentTablePage($Res, $totalPage, $active);
    }

    public function studentTablePage($Res, $totalPage, $active){

        $tBody = $page = ''; $count = 0;

        if(count($Res)){
            foreach($Res as $value){
                if($value->profile)
                    $img = '<img src="assets/profile/'.$value->profile.'" width="40px">';
                else $img = '';
                $tBody .= '
                    <tr id="'.$value->id.'">
                        <td>'.++$count.'.</td>
                        <td>'.$img.'</td>
                        <td>'.$value->name.'</td>
                        <td>'.$value->phone.'</td>
                        <td>'.$value->email.'</td>
                        <td>'.$value->address.'</td>
                        <td>
                            <a href="student/detail/'.$value->id.'" class="btn btn-info btn-sm"><i class="far fa-folder-open"></i></a>
                            <a href="#" class="btn btn-danger btn-sm removeData"><i class="fas fa-times"></i></a>
                        </td>
                    </tr>
                ';
            }
        } else{
            $tBody = '
                <tr>
                    <td>1.</td>
                    <td colspan="5" align="center">No Data Found...</td>
                </tr>
            ';
        }

        if($active == 1){
            $status = 'active'; $prev = 'disabled';
        } else {
            $status = ''; $prev = '';
        }

        $page .= '
            <li class="page-item '.$prev.'"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item '.$status.'"><a class="page-link" href="#">1</a></li>
        ';
        for($i = 2; $i <= $totalPage; $i++){
            $status = ($active == $i) ? 'active' : '';
            $page .= '<li class="page-item '.$status.'"><a class="page-link" href="#">'.$i.'</a></li>';
        }

        if($active == $totalPage) $dis = 'disabled'; else $dis = '';
        $page .= '<li class="page-item '.$dis.'"><a class="page-link" href="#">Next</a></li>';

        //return json_encode($page);
        return json_encode(array('tBody' => $tBody, 'Pagination' => $page));
    }

}
