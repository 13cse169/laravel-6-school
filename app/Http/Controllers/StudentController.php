<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Student;

use File;
use MyHelper;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.list', array('students' => Student::GetStudent(0, 5)));
    }

    public function create()
    {
        $_School = new School();

        $form_fields = MyHelper::getFormFields('student-add-form');
        $enc_fields  = MyHelper::encryptFormField($form_fields);

        return view('student.add', array('schools' => $_School->GetTable()))->with('encrypted', $enc_fields);
    }

    public function store(Request $request)
    {

        dd($_POST);
        $allRequest  = $request->all();
        $white_lists = MyHelper::getFormFields("student-add-form");
        $ignore_keys = array('_token');
        $post_data   = MyHelper::decryptForm($allRequest, $white_lists, $ignore_keys);

        if(isset($post_data['language'])) $post_data['language'] = implode(',', $post_data['language']);

        $imgPath = 'assets/profile/';
        if (!file_exists($imgPath)) File::makeDirectory($imgPath, $mode = 0777, true, true);

        $tmp = explode('.', $_FILES['profile']['name']);
        $imgName = date('Ymd-His') . '.' . end($tmp);

        if (move_uploaded_file($_FILES['profile']['tmp_name'], $imgPath . $imgName))
            $post_data['profile'] = $imgName;

        Student::Insert($post_data);

        return redirect('student')->with('added', 'success');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
