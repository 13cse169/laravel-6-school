<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Jobs\SendMailJobs;

use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee.list', [
            'employee' => Employee::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.add');

        /* $email = 'birendra.singh@massoftind.com';
        $body  = 'You got this mail from Laravel Job.';

        dispatch(new SendMailJobs($email, $body));
        echo $message = "Job added successfully"; */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'department' => 'required',
            'address'    => 'required',
        ]);

        $empData = Employee::create($data);
 
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            //$imageName = time().'.'.$image->getClientOriginalExtension();
            
            //if (Storage::put('emp/'.$empData->id.'/'.$imageName, $image)) {

            if (Storage::put('emp/'.$empData->id, $image)) {
                
                echo 1;
            
            } else {

                echo 0;

            }

        }

        //dd($request->all());

        //return redirect('employee')->with('added', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
