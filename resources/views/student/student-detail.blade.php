@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">Student Details</div>
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select School :</label>
                                    <select class="form-control selectSchool" name="school_id" required="true">
                                        <option value="" hidden="true"></option>
                                        @foreach($School as $value)
                                            <option value="{{ $value->id }}" {{ ($Student->school_id == $value->id) ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Select Teacher :</label>
                                    <select class="form-control selectTeacher" name="teacher_id[]" multiple="multiple" required="true" style="width: 100%;">
                                        @foreach($Teacher as $value)
                                            <option value="{{ $value->id }}" {{ (in_array($value->id, $mapTeach)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Student Name :</label>
                                    <input type="text" class="form-control" name="name" value="{{ $Student->name }}" required="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Phone Number :</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $Student->phone }}" required="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Email :</label>
                                    <input type="email" class="form-control" value="{{ $Student->email }}" name="email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Gender :</label><br>
                                    <input type="radio" class="" name="gender" value="Male" {{ ($Student->gender == 'Male') ? 'checked' : '' }}>
                                    <span>Male</span><br>
                                    <input type="radio" class="" name="gender" value="Female" {{ ($Student->gender == 'Female') ? 'checked' : '' }}>
                                    <span>Female</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    @php($langArray = explode(',', $Student->language))
                                    <label for="">Select your Language :</label><br>
                                    <input type="checkbox" class="" name="language[]" value="English" {{ (in_array('English', $langArray)) ? 'checked' : '' }}>
                                    <span>English</span><br>
                                    <input type="checkbox" class="" name="language[]" value="Hindi" {{ (in_array('Hindi', $langArray)) ? 'checked' : '' }}>
                                    <span>Hindi</span><br>
                                    <input type="checkbox" class="" name="language[]" value="Bengali" {{ (in_array('Bengali', $langArray)) ? 'checked' : '' }}>
                                    <span>Bengali</span><br>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Enter Address :</label>
                                    <textarea class="form-control" name="address">{{ $Student->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button class="btn btn-info btn-block">Update Student Data</button>
                                </div>
                            </div>
                        </div>
                    </form>
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