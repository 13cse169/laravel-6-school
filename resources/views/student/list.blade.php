@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Student List </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">List</li>
            </ol>
        </nav>
    </div>

    <div id="toast"><div id="img"><i class="fas fa-bell"></i></div><div id="notifyMsg"></div></div>

    <div class="row quick-action-toolbar">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Student List</h5>
                </div>
                <div class="row p-3">
                    <div class="col-md-3">
                        <a href="{{ url('student/add') }}" class="btn btn-sm btn-outline-dark btn-fw">
                            Add Student <i class="fas fa-user-plus"></i>
                        </a>
                    </div>
                    <div class="col-md-9"></div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-hover" data-table="teacher_master">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Profile </th>
                                <th> Name </th>
                                <th> School </th>
                                <th> Phone </th>
                                <th> Email </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($students))
                                @php($count = 0)
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="py-1">{{ ++$count }} .</td>
                                        <td>
                                            <img src="{{ asset('assets/profile/'.$student->profile) }}" alt="image" />
                                        </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->sclName }} </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ $student->email }} </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="py-1">1.</td>
                                    <td class="text-center">No data found...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
