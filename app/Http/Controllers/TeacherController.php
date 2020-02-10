<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\School;
use Illuminate\Http\Request;
use App\Exports\TeacherExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use MyHelper;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myArray = [
            'like'     => '',    
            'column'   => 'teachers.id',
            'order'    => 'desc',
            'offset'   => 0,
            'limit'    => env('TOTAL_NO_OF_LIST'),
            'active'   => 1,
            'totalRes' => Teacher::get()->count()
        ];extract($myArray);

        if($request->ajax())
        {
            if($request->searchValue){
                $like     = $request->searchValue;
                $totalRes = count(Teacher::whereLike($request->searchValue));
            }

            if($request->column) { 
                $order = ($request->order == 'sorting_desc') ? 'desc' : 'asc';

                switch ($request->column) {
                    case 'Date'   : $column = 'teachers.created_at'; break;
                    case 'Teacher': $column = 'teachers.name'; break;
                    case 'Phone'  : $column = 'teachers.phone'; break;
                    case 'Email'  : $column = 'teachers.email'; break;
                    default: $column = 'schools.name'; break;
                }

            }
            
            if($request->pNo){
                switch ($request->pNo) {

                    case 'Previous':
                        $offset = (($request->cNo - 2) * $limit);
                        $active = ($request->cNo - 1);
                        break;

                    case 'Next':
                        $offset = ($request->cNo * $limit);
                        $active = ($request->cNo + 1);
                        break;

                    default:
                        $offset = (($request->pNo - 1) * $limit);
                        $active = $request->pNo;
                        break;
                }
            }

            $result    = Teacher::getlist($like, $column, $order, $offset, $limit);
            $tBody     = $this->generateRow(0, $result);
            $totalPage = ceil($totalRes / $limit);

            if(!$tBody){
                $tBody = '
                    <tr style="background-color: #e57373" class="text-white">
                        <td colspan="7" align="center">No data found...</td>
                    </tr>
                ';
            }
            return response()->json([
                'tBody'    => $tBody,
                'pageLink' => MyHelper::generatePageLink($active, $totalPage)
            ]);

        } else {

            $data = [
                'teachers'  => Teacher::getlist($like, $column, $order, $offset, $limit),
                'totalTchr' => ceil($totalRes / $limit)
            ];
            return view('teacher.list', $data);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'schools' => School::get(),
            'teacher' => new Teacher()
        ];
        return view('teacher.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Teacher $teacher)
    {
        $teacher = Teacher::create($this->validateRequest());
        
        $this->storeImage($teacher);

        return redirect('teacher')->with('notifyMsg', 'Teacher added successfully...!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('teacher.details', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $data = [
            'schools' => School::get(),
            'teacher' => $teacher
        ];
        return view('teacher.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Teacher $teacher)
    {
        $teacher->update($this->validateRequest());

        $this->storeImage($teacher);

        return redirect('/teacher/'.$teacher->id)->with('notifyMsg', 'School updated successfully...!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return response()->json(Teacher::deleteRecord($request->id));
    }

    private function validateRequest()
    {
        return tap(request()->validate([
            'name'    => 'required|min:3|max:100',
            'phone'   => 'required|digits:10',
            'email'   => 'required|email',
            'address' => 'required',
            'school_id' => 'required'
        ]), function(){
            if(request()->hasFile('profile')){
                request()->validate([
                    'profile' => 'required|image'
                ]);
            }
        });
    }

    private function storeImage($teacher)
    {
        if(request()->has('profile'))
        {
            $path = request()->profile->store('uploads/teacher/'.$teacher->id.'/profile', 'public');
            $teacher->update([ 'profile' => $path ]);
        }
    }

    public function exportData(Request $request)
    {
        $like = ''; $column = 'teachers.id'; $order = 'desc';

        if($request->exportValue) $like = $request->exportValue;

        if($request->exportColumn) { 
            $order = ($request->exportOrder == 'sorting_desc') ? 'desc' : 'asc';

            switch ($request->exportColumn) {
                case 'Date'   : $column = 'teachers.created_at'; break;
                case 'Teacher': $column = 'teachers.name'; break;
                case 'Phone'  : $column = 'teachers.phone'; break;
                case 'Email'  : $column = 'teachers.email'; break;
                default: $column = 'schools.name'; break;
            }

        }
        
        if ($request->exportType == 'excel') {

            //return Excel::download(new SchoolExport($like, $column, $order), 'school-list.xlsx');

            return (new TeacherExport($like, $column, $order))->download('teacher-list.xlsx');

        } else {
            
            $teachers = Teacher::getlist($like, $column, $order, '', '');

            $pdf = PDF::loadView('teacher.pdf', compact('teachers'));
            
            return $pdf->download('teachers-list.pdf');
        }
    }

    private function generateRow($count, $result)
    {
        $row = '';
        foreach ($result as $key => $teacher) {
            //<td>'.++$count.'.</td>
            $row .= '
                <tr id="'.$teacher->id.'">
                    <td>
                        <img src="'.asset('storage/'.$teacher->profile).'" alt="logo">
                    </td>
                    <td>'.date('d-M-y', strtotime($teacher->created_at)).'</td>
                    <td>'.substr($teacher->schoolName, 0, 20).'...</td>
                    <td>'.$teacher->name.'</td>
                    <td>'.$teacher->phone.'</td>
                    <td>'.substr($teacher->email, 0, 20).'...</td>
                    <td>
                        <a href="'.url('teacher/'.$teacher->id).'" class="btn btn-sm btn-rounded btn-outline-primary">
                            <i class="far fa-folder-open"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-rounded btn-outline-danger removeData">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            ';    
        }
        return $row;
    }
}
