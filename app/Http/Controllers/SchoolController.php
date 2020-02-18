<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\Student;
use App\Exports\SchoolExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use MyHelper;
use FormSecurity;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;

class SchoolController extends Controller
{
    protected $encryptMethod = 'AES-256-CBC';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
/* 
        $myArray = [
            'like'     => 'like',
            'column'   => 'column',
            'order'    => 'order',
            'offset'   => 'offset',
        ];

        echo'<pre>';

        print_r($myArray);

        $encryptedFields = FormSecurity::encryptFormField($myArray);

        print_r($encryptedFields);

        $decryptedFields = FormSecurity::decryptFormField($encryptedFields);

        print_r($decryptedFields);

        exit();
 */        
        //$encrypt = FormSecurity::encrypt('Hello', 'Birendra Singh');
        //echo FormSecurity::decrypt($encrypt, 'Birendra Singh');

        $myArray = [
            'like'     => '',    
            'column'   => 'id',
            'order'    => 'desc',
            'offset'   => 0,
            'limit'    => env('TOTAL_NO_OF_LIST'),
            'active'   => 1,
            'totalRes' => School::get()->count()
        ];extract($myArray);

        if ($request->ajax()) {
 
            if($request->searchValue){
                $like     = $request->searchValue;
                $totalRes = count(School::whereLike($request->searchValue));
            }

            if($request->column) { 
                $order = ($request->order == 'sorting_desc') ? 'desc' : 'asc';

                switch ($request->column) {
                    case 'Date'   : $column = 'created_at'; break;
                    case 'School' : $column = 'name'; break;
                    case 'Phone'  : $column = 'phone'; break;
                    case 'Email'  : $column = 'email'; break;
                    default: $column = 'address'; break;
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

            $result    = School::getlist($like, $column, $order, $offset, $limit);
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
                'schools'   => School::getlist($like, $column, $order, $offset, $limit),
                'totalScol' => ceil($totalRes / $limit)
            ];
            return view('school.list', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school = new School();
        return view('school.create', compact('school'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(School $school)
    {
        $school = School::create($this->validateRequest());
        
        $this->storeImage($school);

        return redirect('school')->with('notifyMsg', 'School added successfully...!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        return view('school.details', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        return view('school.create', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(School $school)
    {
        $school->update($this->validateRequest());

        $this->storeImage($school);
        
        return redirect('/school/'.$school->id)->with('notifyMsg', 'School updated successfully...!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return response()->json(School::deleteRecord($request->id));
    }

    private function validateRequest()
    {
        return tap(request()->validate([
            'name'    => 'required|min:3|max:100',
            'phone'   => 'required|digits:10',
            'email'   => 'required|email',
            'address' => 'required'
        ]), function(){
            if (request()->hasFile('logo')) {
                request()->validate([
                    'logo' => 'required|image'
                ]);
            }
        });
    }

    private function storeImage($school)
    {
        if(request()->has('logo')) {
            $path = request()->logo->store('uploads/school/'.$school->id.'/logo', 'public');
            $school->update([ 'logo' => $path ]);
        }
    }

    public function exportData(Request $request)
    {
        $like = ''; $column = 'id'; $order = 'desc';

        if($request->exportValue) $like = $request->exportValue;

        if($request->exportColumn) { 
            $order = ($request->exportOrder == 'sorting_desc') ? 'desc' : 'asc';

            switch ($request->exportColumn) {
                case 'Date'   : $column = 'created_at'; break;
                case 'School' : $column = 'name'; break;
                case 'Phone'  : $column = 'phone'; break;
                case 'Email'  : $column = 'email'; break;
                default: $column = 'address'; break;
            }

        }
        
        if ($request->exportType == 'excel') {

            //return Excel::download(new SchoolExport($like, $column, $order), 'school-list.xlsx');

            return (new SchoolExport($like, $column, $order))->download('school-list.xlsx');

        } else {
            
            $schoolData = School::getlist($like, $column, $order, '', '');

            $pdf = PDF::loadView('school.pdf', compact('schoolData'));
            
            return $pdf->download('school-list.pdf');
        }
    }

    private function generateRow($count, $result)
    {
        $row = '';
        foreach ($result as $key => $school) {
            //<td>'.++$count.'.</td>
            $row .= '
                <tr id="'.$school->id.'">
                    <td>
                        <img src="'.asset('storage/'.$school->logo).'" alt="logo">
                    </td>
                    <td>'.date('d-M-y', strtotime($school->created_at)).'</td>
                    <td>'.substr($school->name, 0, 20).'...</td>
                    <td>'.$school->phone.'</td>
                    <td>'.substr($school->email, 0, 20).'</td>
                    <td>'.substr($school->address, 0, 15).'</td>
                    <td>
                        <a href="'.url('school/'.$school->id).'" class="btn btn-sm btn-rounded btn-outline-primary">
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
