@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Employee Add </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('employee/') }}">Employee List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>

    <div class="row quick-action-toolbar">
        <div class="col-md-10 m-auto grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Enter Employee Information</h5>
                    <p class="ml-auto mb-0">All details are mandatory.<i class="icon-bulb"></i></p>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" action="{{ url('employee/add/save') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter Name :</label>
                                            <input type="text" class="form-control form-control-sm required @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter Number :</label>
                                            <input type="number" class="form-control form-control-sm phoneTrue required @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                                            <small class="text-danger">{{ $errors->first('phone') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter Email :</label>
                                            <input type="text" class="form-control emailTrue required @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter Department :</label>
                                            <select name="department" class="form-control form-control-sm required">
                                                <option value="" hidden="true"></option>
                                                <option value="CSE" {{ old('department') == 'CSE' ? 'selected' : ''}}>CSE</option>
                                                <option value="ECE" {{ old('department') == 'ECE' ? 'selected' : ''}}>ECE</option>
                                                <option value="E&I" {{ old('department') == 'E&I' ? 'selected' : ''}}>E&I</option>
                                                <option value="IT" {{ old('department') == 'IT' ? 'selected' : ''}}>IT</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('department') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter Address :</label>
                                            <input class="form-control form-control-sm required address @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                                            <small class="text-danger">{{ $errors->first('address') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="image">Upload Image</label>
                                            <input type="file" name="image" id="image" class="form-control form-control-sm required">
                                        </div>
                                        <div class="col-md-6 m-auto form-group">
                                            <button class="btn btn-outline-primary btn-block">Add Employee</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection