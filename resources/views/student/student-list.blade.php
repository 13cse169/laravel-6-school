@extends('layouts.app')

@section('content')
<div class="container">
        
    <div id="toast"><div id="img"><i class="fas fa-bell"></i></div><div id="notifyMsg"></div></div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student</li>
        </ol>
    </nav>

    <div id="accordion">
        <div class="card">
            <div class="card-header p-0 bg-dark" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white" data-toggle="collapse" data-target="#addSchool" aria-expanded="false" aria-controls="addSchool">
                    Add New Student
                    </button>
                </h5>
            </div>
            <div id="addSchool" class="collapse {{ ($sID) ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select School :</label>
                                    <select class="form-control selectSchool" name="school_id" required="true">
                                        <option value="" hidden="true"></option>
                                        @foreach($School as $value)
                                            <option value="{{ $value->id }}" {{ ($sID == $value->id) ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select Teacher :</label>
                                    <select class="form-control selectTeacher" name="teacher_id[]" multiple="multiple" required="true" style="width: 100%;">
                                        @if($sID)
                                            @foreach($TeacherList as $list)
                                                <option value="{{ $list->id }}" {{ ($list->id == $Teacher->id) ? 'selected' : '' }}>{{ $list->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled="true">Select School First...</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Student Name :</label>
                                    <input type="text" class="form-control" name="name" required="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Phone Number :</label>
                                    <input type="number" class="form-control" name="phone" required="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Email :</label>
                                    <input type="email" class="form-control" name="email" required="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select Profile Photo :</label>
                                    <input type="file" class="form-control" name="profile" required="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Gender :</label><br>
                                    <input type="radio" class="" name="gender" value="Male" checked="true">
                                    <span>Male</span><br>
                                    <input type="radio" class="" name="gender" value="Female">
                                    <span>Female</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select your Language :</label><br>
                                    <input type="checkbox" class="" name="language[]" value="English">
                                    <span>English</span><br>
                                    <input type="checkbox" class="" name="language[]" value="Hindi">
                                    <span>Hindi</span><br>
                                    <input type="checkbox" class="" name="language[]" value="Bengali">
                                    <span>Bengali</span><br>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Address :</label>
                                    <textarea class="form-control" name="address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button class="btn btn-info btn-block">Add Student</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-0 bg-dark" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white collapsed" data-toggle="collapse" data-target="#schoolList" aria-expanded="true" aria-controls="schoolList">
                    Student List
                    </button>
                </h5>
            </div>
            <div id="schoolList" class="collapse {{ ($sID) ? '' : 'show' }}" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="text-center">
                        <h4 class="font-weight-bold  mb-3">Student List</h4>
                    </div>
                    <form action="" method="post" id="GetStudent">
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select School :</label>
                                    <select class="form-control studSchool">
                                        <option value="" hidden="true"></option>
                                        <!-- <option value="">All</option> -->
                                        @foreach($School as $value)
                                            <option value="{{ $value->id }}" {{ ($sID == $value->id) ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Student Name :</label>
                                    <input class="form-control studName">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-info text-white">Search <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive border border-dark rounded">
                        <table class="table table-hover" data-table="student_master">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tBody">
                                @if(count($Student))
                                    @php($count = 0)
                                    @foreach($Student as $value)
                                        <tr id="{{ $value->id }}">
                                            <td>{{ ++$count }}.</td>
                                            <td>
                                                @if($value->profile)
                                                    <img src="assets/profile/{{ $value->profile }}" width="40px">
                                                @endif 
                                            </td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->phone }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->address }}</td>
                                            <td>
                                                <a href="{{ url('student/detail/'.$value->id) }}" class="btn btn-info btn-sm"><i class="far fa-folder-open"></i></a>
                                                <!-- <a href="#" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a> -->
                                                <a href="#" class="btn btn-danger btn-sm removeData"><i class="fas fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>1.</td>
                                        <td colspan="5" align="center">No Data Found...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="d-flex justify-content-center mt-3"> -->
                    <div class="d-flex float-right mt-3">
                        <nav aria-label="...">
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                @for($i = 2; $i <= $totalPage; $i++)
                                    <li class="page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item {{ ($totalPage < 2) ? 'disabled' : '' }}"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('.selectTeacher').select2();

        $(document).on('change', '.selectSchool', function(event) {
            var sID = $(this).val();
            $.ajax({
                url: "{{ url('/get/teacher') }}",
                type: 'POST',
                dataType: 'json',
                data: {sID: sID,  _token: '{{ csrf_token() }}'},
            })
            .done(function(res) {
                //console.log(res);
                $('.selectTeacher').html(res);
            })
            .fail(function() {
                console.log("error");
            });
            
        });
        
    });
</script>
@endsection