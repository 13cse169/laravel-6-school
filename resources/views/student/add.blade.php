@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Student List </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>

    <div class="row quick-action-toolbar">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Student List</h5>
                    <p class="ml-auto mb-0">All details are mandatory.<i class="icon-bulb"></i></p>
                </div>
                <form class="forms-sample" action="{{ url('student/add/new') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-3">
                        <div class="col-md-4 form-group">
                            <label for="">School</label>
                            <select name="{{ $encrypted['school_id'] }}" id="{{ $encrypted['school_id'] }}" class="form-control form-control-sm school-id required">
                                <option value="" hidden="true">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-4 form-group">
                            <label for="">Teacher</label>
                            <select name="{{ $encrypted['teacher_id'] }}[]" id="{{ $encrypted['teacher_id'] }}" class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                                <option value="AM">America</option>
                                <option value="CA">Canada</option>
                                <option value="RU">Russia</option>
                            </select>
                        </div> --}}
                        <div class="col-md-4 form-group">
                            <label for="">Name</label>
                            <input name="{{ $encrypted['name'] }}" id="{{ $encrypted['name'] }}" type="text" class="form-control form-control-sm required" placeholder="Name">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Phone number</label>
                            <input name="{{ $encrypted['phone'] }}" id="{{ $encrypted['phone'] }}" type="number" class="form-control form-control-sm phoneTrue required" placeholder="Phone">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Email address</label>
                            <input name="{{ $encrypted['email'] }}" id="{{ $encrypted['email'] }}" type="text" class="form-control form-control-sm emailTrue required" placeholder="Email">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>File upload</label>
                            <input name="profile" type="file" class="form-control required form-control-sm">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Address</label>
                            <textarea name="{{ $encrypted['address'] }}" id="{{ $encrypted['address'] }}" class="form-control required" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Select Language</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input name="{{ $encrypted['language'] }}[]" type="checkbox" class="form-check-input" value="Hindi"> Hindi </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input name="{{ $encrypted['language'] }}[]" type="checkbox" class="form-check-input" value="English"> English </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input name="{{ $encrypted['language'] }}[]" type="checkbox" class="form-check-input" value="Bengali"> Bengali </label>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Select Gender</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input name="{{ $encrypted['gender'] }}" type="radio" class="form-check-input" name="optionsRadios" value="Male" checked> Male </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input name="{{ $encrypted['gender'] }}" type="radio" class="form-check-input" name="optionsRadios" value="Female"> Female </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function ($) {
            /* $(document).on('change', '.school-id', function(e){
                var sid = $(this).val();
                $.ajax({
                    url: "{{ url('teacher/school-teacher') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {sID: sid,  _token: '{{ csrf_token() }}'},
                })
                .done(function(res) {
                    //console.log(res);
                    $('.js-example-basic-multiple').html(res);
                })
                .fail(function() {
                    console.log("error");
                });
            }); */
        });
    </script>
@endsection
