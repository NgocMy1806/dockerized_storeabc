@extends('admin.layout.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List categories</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"> Category index </div>

                        </div>
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert-success">{{ session()->get('success') }}</div>
                            @endif
                            <a href="{{ route('categories.create') }}" class="btn btn-outline-info">Add category</a>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">name</th>
                                        <th scope="col">slug</th>
                                        <th scope="col">parent category</th>
                                        <th scope="col">status</th>
                                        <th scope="col">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <th scope="row">{{ $category->id }}</th>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->parentCategory->name ?? '-' }}</td>
                                            <td><input type="checkbox"
                                                    data-url="{{ route('categories.update', $category->id) }}" name=""
                                                    class="toggle-active" id=""
                                                    {{ $category->status == 1 ? 'checked' : '' }}></td>
                                            <td>
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a
                                                    href="{{ route('categories.show', $category->id) }}"class="btn btn-success">View</a>
                                                <button type="button" class="btn btn-default destroy-cat deletebutton1"
                                                    data-toggle="modal"
                                                    data-target="#deletemodal"data-url="{{ route('categories.destroy', $category->id) }}"
                                                    id="deletebutton1">Delete </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </div>
        </div>
        <!-- /.card -->


        <div class="modal fade" id="deletemodal" style="display: none; padding-right: 17px;" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure?</p>
                    </div>
                    <form action="" method="post">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="id"value="">
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary deletebutton2" id="deletebutton2">Delete</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endsection

    @push('custom-js')
        <script>
            $(document).ready(function() {

                $('.toggle-active').on('click', function() {
                    const url = $(this).data('url');
                    console.log(url);
                    console.log($(this).is(':checked'));
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: $(this).is(':checked') ? 1 : 0,
                        },
                        dataType: 'json',
                        success: function(data) {
                            toastr.success(data.success)
                        }
                    });
                });
            })
        </script>
        <script>
            
                $(document).on("click", ".deletebutton1", function() {
                    var delUrl = $(this).attr('data-url');
                    $(".deletebutton2").attr('data-url', delUrl);
                    console.log(delUrl);
                    $('.deletebutton2').on('click', function(){
                    const delUrl = $('.this').attr('data-url');
                    console.log(delUrl);
                   

                    $.ajax({
                        type: "DELETE",
                        url: delUrl,
                        data: {
                            _token: '{{ csrf_token() }}',
                            // id: $(this).is(':checked') ? 1 : 0,
                        },
                        dataType: 'json',
                        success: function(data) {
                            toastr.success(data.success)
                        }
                    });
                });
                });
                
                
            
        </script>
    @endpush
