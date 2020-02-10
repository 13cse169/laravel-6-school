@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Teacher Add </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('teacher/') }}">Teacher List</a></li>
                @if (request()->is('teacher/create'))
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ url('teacher/'.$teacher->id) }}">Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                @endif
            </ol>
        </nav>
    </div>

    <div class="row quick-action-toolbar">
        <div class="col-md-10 m-auto grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Teacher Information</h5>
                    @if (request()->is('teacher/create'))
                        <i class="ml-auto mb-0">All details are mandatory.<i class="icon-bulb"></i></i>
                    @else
                        <img class="ml-auto mb-0 img-sm rounded-circle" src="{{ asset('storage/'.$teacher->profile) }}" alt="profile image">
                    @endif
                </div>
                <form action="{{ url('teacher/'.$teacher->id) }}" method="post" enctype="multipart/form-data">
                    @if ($teacher->id) @method('PATCH') @endif
                    @csrf
                    <div class="row p-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Enter School :</label>
                                <select class="form-control form-control-sm required" name="school_id">
                                    <option value="" hidden="true"></option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}" {{ old('school_id') ?? $teacher->school_id == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{ $errors->first('school_id') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Enter Teacher Name :</label>
                                <input type="text" class="form-control form-control-sm required" name="name" value="{{ old('name') ?? $teacher->name }}">
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Enter Phone Number :</label>
                                <input type="number" class="form-control form-control-sm required" name="phone" value="{{ old('phone') ?? $teacher->phone }}">
                            <small class="text-danger">{{ $errors->first('phone') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Enter Email :</label>
                                <input type="text" class="form-control form-control-sm required email-true" name="email" value="{{ old('email') ?? $teacher->email }}">
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Upload Profile :</label>
                            <input type="file" class="form-control form-control-sm required" name="profile">
                            <small class="text-danger">{{ $errors->first('profile') }}</small>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Enter Address :</label>
                                <textarea class="form-control form-control-sm required" name="address">{{ old('address') ?? $teacher->address }}</textarea>
                            <small class="text-danger">{{ $errors->first('address') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 m-auto">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-outline-primary btn-block">
                                    {{ request()->is('teacher/create') ? 'Add' : 'Update' }} Teacher
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
