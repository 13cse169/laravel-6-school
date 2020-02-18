@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> School List </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">School List</li>
            </ol>
        </nav>
    </div>

    <div id="toast"><div id="img"><i class="fas fa-bell"></i></div><div id="notifyMsg"></div></div>

    <div class="row quick-action-toolbar">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">School List</h5>
                    <a href="{{ url('school/create') }}" class="ml-auto mb-0 btn btn-rounded btn-fw btn-outline-dark btn-sm">
                        Add School <i class="fas fa-school"></i>
                    </a>
                </div>
                <div class="row p-3">
                    <div class="col-md-3">
                        <form id="exportData" action="{{ url('school/export/data') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="hidden" name="exportValue" class="exportValue">
                                <input type="hidden" name="exportColumn" class="exportColumn">
                                <input type="hidden" name="exportOrder" class="exportOrder">
                                <select name="exportType" id="exportType" class="form-control form-control-sm">
                                    <option value="" hidden="true">Export Data</option>
                                    <option value="excel">Export to Excel</option>
                                    <option value="pdf">Export to PDF</option>
                                </select>
                                <div class="input-group-append exportDataAppend">
                                    <button type="submit" class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        {{-- <div class="input-group">
                            <input type="text" class="form-control" placeholder="Start Date">
                            <input type="text" class="form-control" placeholder="End Date">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-dark">Search <i class="fas fa-search"></i></button>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-3 form-group">
                        <form id="rowSearch" action="#" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm searchValue" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-outline-dark" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Logo</th>
                                <th>Date</th>
                                <th>School</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tBody">
                            @if(count($schools))
                                @php($count = 0)
                                @foreach($schools as $school)
                                    <tr id="{{ $school->id }}">
                                        {{-- <td>{{ ++$count }}.</td> --}}
                                        <td><a href="{{ asset('storage/'.$school->logo) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$school->logo) }}" alt="logo">
                                        </a></td>
                                        <td>{{ date('d-M-y', strtotime($school->created_at)) }}</td>
                                        <td>{{ substr($school->name, 0, 20) }}...</td>
                                        <td>{{ $school->phone }}</td>
                                        <td>{{ substr($school->email, 0, 20) }}...</td>
                                        <td>{{ substr($school->address, 0, 15) }}...</td>
                                        <td>
                                            <a href="{{ url('school/'.$school->id) }}" class="btn btn-sm btn-rounded btn-outline-primary">
                                                <i class="far fa-folder-open"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-rounded btn-outline-danger removeData">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr style="background-color: #e57373" class="text-white">
                                    <td colspan="7" align="center">No data found...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <hr>
                    <div class="float-right mr-3">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                @for($i = 2; $i <= $totalScol; $i++)
                                    <li class="page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item {{ ($totalScol < 2) ? 'disabled' : '' }}"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            
            $('table th:not(:first-child, :last-child)').each(function($i, $e){
                $(this).addClass('sorting').append('<i class="text-muted fas fa-sort"></i></span>');
                $(this).hover(function () {
                    $(this).css("cursor", "pointer");  
                });
            });

            $('#rowSearch').submit(function(e){
                e.preventDefault();
                var searchValue = $('.searchValue').val();
                myFunction(searchValue, '', '', '', '');
            });

            $(document).on('click', 'thead th', function(){
                
                if($(this).hasClass('sorting_asc') || $(this).hasClass('sorting')){

                    $('table th:not(:first-child, :last-child)').each(function($i, $e){
                        $(this).attr('class', 'sorting');
                        $(this).find('.fas').attr('class', 'text-muted fas fa-sort');
                    });

                    $(this).attr('class', 'sorting_desc');
                    $(this).find('.fas').addClass('fa-sort-down').removeClass('fa-sort');
                    
                    var column = $(this).text();
                    var order  = $(this).attr('class');

                } else {
                    $('table th:not(:first-child, :last-child)').each(function($i, $e){
                        $(this).attr('class', 'sorting');
                        $(this).find('.fas').attr('class', 'text-muted fas fa-sort');
                    });
                    
                    $(this).attr('class', 'sorting_asc');
                    $(this).find('.fas').addClass('fa-sort-up').removeClass('fa-sort');
                    
                    var column = $(this).text();
                    var order  = $(this).attr('class');

                }
                var searchValue = $('.searchValue').val();
                if(column != 'Action' && column != 'Logo')
                    myFunction(searchValue, column, order, '', '');
            });
            
            $(document).on('click', '.page-item', function (e) {
                e.preventDefault();

                var searchValue = $('.searchValue').val();
                var column = $(document).find('.sorting_desc, .sorting_asc').text();
                var order  = $(document).find('.sorting_desc, .sorting_asc').attr('class');

                if(!$(this).hasClass('disabled') && !$(this).hasClass('active')){

                    var ulTag = $(this).closest('.pagination');
                    var cNo = $(ulTag).find('.active').removeClass('active').text();
                    var pNo = $(this).text();

                    myFunction(searchValue, column, order, cNo, pNo);
                }

            });

            $('#exportData').submit(function(e){
                
                var exportType = $('#exportType').val();
                if (exportType) {
                    
                    $('.exportValue').val($('.searchValue').val());
                    $('.exportColumn').val($(document).find('.sorting_desc, .sorting_asc').text());
                    $('.exportOrder').val($(document).find('.sorting_desc, .sorting_asc').attr('class'));

                } else {
                    e.preventDefault();

                    $('#notifyMsg').text('Please select an option...');
                    $('#toast').addClass('show');
                    setTimeout( () => { $('#toast').removeClass('show') }, 5000);
                }
            });
            
            $(document).on('click', '.removeData', function(event) {

                var tr = $(this).closest('tr');
                var id = $(tr).prop('id');
                var table = $(this).closest('table').attr('data-table');

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('school/delete') }}",
                            type: 'POST',
                            dataType: 'json',
                            data: {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'},
                        })
                        .done(function(res) {
                            console.log(res);
                            $(tr).remove();

                            swal("Success!! Your data has been deleted!", {
                                icon: "success",
                            });
                        })
                        .fail(function() {
                            console.log("error");
                            swal("Oops!! Looks like an error occurred!");
                        });
                    }
                });

            });

            function myFunction(searchValue, column, order, cNo, pNo){
                $.ajax({
                    url: "{{ url('school') }}",
                    type: 'get',
                    dataType: 'json',
                    data: {searchValue: searchValue, column: column, order: order, cNo: cNo, pNo: pNo, _token: '{{ csrf_token() }}'},
                })
                .done(function(res){
                    //console.log(res.tBody);
                    $('#tBody').html(res.tBody);
                    $('.pagination').html(res.pageLink);
                })
                .fail(function(){
                    console.log('error');
                });
            }

        });
    </script>

    @if (session('success'))
        <script>
            $(document).ready(function () {
                $('#notifyMsg').text('Data added successfully...!!');
                $('#toast').addClass('show');
                setTimeout( () => { $('#toast').removeClass('show') }, 5000);
            });
        </script>
    @endif
@endsection
