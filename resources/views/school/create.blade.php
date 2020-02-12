@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> School </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('school/') }}">School List</a></li>
                @if (request()->is('school/create'))
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ url('school/'.$school->id) }}">Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                @endif
            </ol>
        </nav>
    </div>

    {{
        url()->previous()
    }}

    <div class="row quick-action-toolbar">
        <div class="col-md-10 m-auto grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    {{-- <h5 class="mb-0">School Information</h5> --}}
                    <h5 class="mb-0">{{ __('myText.sclinfo') }}</h5>
                    @if (request()->is('school/create'))
                        <i class="ml-auto mb-0">All details are mandatory.<i class="icon-bulb"></i></i>
                    @else
                        <img class="ml-auto mb-0 img-sm rounded-circle" src="{{ asset('storage/'.$school->logo) }}" alt="profile image">
                    @endif
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" action="{{ url('/school/'.$school->id) }}" method="POST" enctype="multipart/form-data">
                                    @if ($school->id) @method('PATCH') @endif
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter School Name :</label>
                                            <input type="text" class="form-control form-control-sm required @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $school->name }}">
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter Phone Number :</label>
                                            <input type="number" class="form-control form-control-sm phoneTrue required @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ?? $school->phone }}">
                                            <small class="text-danger">{{ $errors->first('phone') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter School Email :</label>
                                            <input type="text" class="form-control emailTrue required @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $school->email }}">
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Enter School Address :</label>
                                            <input class="form-control form-control-sm required @error('address') is-invalid @enderror" name="address" value="{{ old('address') ?? $school->address }}">
                                            <small class="text-danger">{{ $errors->first('address') }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Upload Logo :</label>
                                            <input type="file" class="form-control form-control-sm @error('logo') is-invalid @enderror" name="logo">
                                            <small class="text-danger">{{ $errors->first('logo') }}</small>
                                        </div>
                                        <div class="col-md-6 m-auto form-group">
                                            <button class="btn btn-outline-primary btn-block">
                                                {{ request()->is('school/create') ? 'Add' : 'Update' }} School
                                            </button>
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

