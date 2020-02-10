@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Send Mail </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Send Mail</li>
            </ol>
        </nav>
    </div>

    <div class="row quick-action-toolbar">
        <div class="col-md-10 m-auto grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Enter Details</h5>
                    <p class="ml-auto mb-0">All details are mandatory.<i class="icon-bulb"></i></p>
                </div>
                <form action="{{ url('send-mail/send') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-3">
                        <div class="col-md-6 form-group">
                            <label for="">Enter Your Name :</label>
                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror required" name="name" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Enter Phone Number :</label>
                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror required" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Enter Your Email :</label>
                            <input type="text" class="form-control form-control-sm @error('email') is-invalid @enderror required" name="email" value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Select an Attachment :</label>
                            <input type="file" class="form-control form-control-sm" name="attachment">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Enter Description :</label>
                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror required" name="description">{{ old('description') }}</textarea>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-outline-primary btn-block">Send Amil</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('mailSent'))
        <script>
            $(document).ready(function () {
                $('#notifyMsg').text('Your mail has been sent...!!');
                $('#toast').addClass('show');
                setTimeout( () => { $('#toast').removeClass('show') }, 5000);
            });
        </script>
    @endif
@endsection