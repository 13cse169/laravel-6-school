@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Employee </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Employee List</li>
            </ol>
        </nav>
    </div>

    <div id="toast"><div id="img"><i class="fas fa-bell"></i></div><div id="notifyMsg"></div></div>

    <div class="row quick-action-toolbar">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Employee List</h5>
                </div>
                <div class="row p-3">
                    <div class="col-md-3">
                        <a href="{{ url('employee/add') }}" class="btn btn-sm btn-outline-dark btn-fw">
                            Add Employee <i class="fas fa-user-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tBody">
                            @if(count($employee))
                                @php( $count = 0 )
                                @foreach ($employee as $emp)
                                    <tr>
                                        <td>{{ ++$count }}.</td>
                                        <td>{{ date('d-M-y', strtotime($emp->created_at)) }}</td>
                                        <td>{{ $emp->name }}</td>
                                        <td>{{ $emp->phone }}</td>
                                        <td>{{ $emp->department }}</td>
                                        <td></td>
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
            </div>
        </div>
    </div>
@endsection
