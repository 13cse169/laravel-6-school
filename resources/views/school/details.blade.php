@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> School Details </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('school/') }}">School List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>

    <div id="toast"><div id="img"><i class="fas fa-bell"></i></div><div id="notifyMsg"></div></div>

    <div class="row quick-action-toolbar">
        <div class="col-md-8 m-auto grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    {{-- <h5 class="mb-0">School Information</h5> --}}
                    <h5 class="mb-0">{{ __('myText.sclinfo') }}</h5>
                    <a href="{{ url('school/'.$school->id.'/edit') }}" class="ml-auto mb-0 btn btn-rounded btn-fw btn-outline-dark btn-sm">
                        Update <i class="far fa-edit"></i>
                    </a>
                </div>
                <div class="row pl-3 pr-3 pt-3">
                    <div class="col-md-2 text-success"><i class="fas fa-school fa-2x"></i></div>
                    <div class="col-md-10 text-right"><span class="text-muted">{{ $school->name }}</span></div>
                </div>
                <hr>
                <div class="row pl-3 pr-3">
                    <div class="col-md-2 text-info"><i class="fas fa-phone-alt fa-2x"></i></div>
                    <div class="col-md-10 text-right"><span class="text-muted">{{ $school->phone }}</span></div>
                </div>
                <hr>
                <div class="row pl-3 pr-3">
                    <div class="col-md-2 text-danger"><i class="fas fa-envelope fa-2x"></i></div>
                    <div class="col-md-10 text-right"><span class="text-muted">{{ $school->email }}</span></div>
                </div>
                <hr>
                <div class="row pl-3 pr-3 pb-3">
                    <div class="col-md-2 text-primary"><i class="fas fa-map-marked-alt fa-2x"></i></div>
                    <div class="col-md-10 text-right"><span class="text-muted">{{ $school->address }}</span></div>
                </div>

            </div>
        </div>
    </div>

    <div class="row quick-action-toolbar mt-3">
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Teacher List</h5>
                    <a href="{{ url('teacher/create') }}" class="ml-auto mb-0 btn btn-rounded btn-fw btn-outline-dark btn-sm">
                        Add Teacher <i class="fas fa-user-plus"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                {{-- <strong><strong>#</strong></strong> --}}
                                <th><strong>Profile</strong></th>
                                <th><strong>Name</strong></th>
                                <th><strong>Phone</strong></th>
                                <th><strong>Action</strong></th>
                            </tr>
                        </thead>
                        <tbody id="tBody">
                            @if(count($school->teachers))
                                @php($count = 0)
                                @foreach($school->teachers as $teacher)
                                    <tr id="{{ $teacher->id }}">
                                        {{-- <td>{{ ++$count }}.</td> --}}
                                        <td><img src="{{ asset('storage/'.$teacher->profile) }}" alt="logo"></td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->phone }}</td>  
                                        <td>
                                            <a href="{{ url('teacher/'.$teacher->id) }}" class="btn btn-outline-primary btn-rounded btn-sm"><i class="far fa-folder-open"></i></a>
                                            <a href="#" class="btn btn-outline-danger btn-rounded btn-sm removeData"><i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr style="background-color: #e57373" class="text-white">
                                    <td colspan="4" align="center">No data found...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Student List</h5>
                    <a href="#" class="ml-auto mb-0 btn btn-rounded btn-fw btn-outline-dark btn-sm">
                        Add Student <i class="fas fa-user-plus"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><strong>#</strong></th>
                                <th><strong>Name</strong></th>
                                <th><strong>Phone</strong></th>
                                <th><strong>Action</strong></th>
                            </tr>
                        </thead>
                        <tbody id="tBody">
                            @if(isset($students) && count($students))
                                @php($count = 0)
                                @foreach($students as $student)
                                    <tr id="{{ $value->id }}">
                                        <td>{{ ++$count }}.</td>
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
                                <tr style="background-color: #e57373" class="text-white">
                                    <td colspan="4" align="center">No data found...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            
        });
    </script>
@endsection
