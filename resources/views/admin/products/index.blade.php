@extends('admin.layout.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

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
                            <div class="card-title">List products </div>

                        </div>
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert-success">{{ session()->get('success') }}</div>
                            @endif
                            <a href="{{ route('products.create') }}" class="btn btn-outline-info">Add product</a>

                            <form action="{{ route('products.index') }}" method="get" id="form-filter">
                                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>

                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item">
                                                <select class="form-control select2 product-filter" name="cat_filter"
                                                    style="width: 100%;" name="category">
                                                    <option value="0">Category</option>
                                                    @foreach ($childrenCat as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ $catSelected == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </ul>
                                        <div class="form-inline my-2 my-lg-0">
                                            <input class="form-control mr-sm-2" type="search" name="text_search"
                                                value="{{ $textSearch ?? '' }}" placeholder="Search" aria-label="Search">
                                            <select class="form-control product-filter" name="sort_key">
                                                <option value="0">Sort By</option>
                                                @foreach ($sortType as $key => $sort)
                                                    <option value="{{ $key }}"
                                                        {{ $key == $sortKey ? 'selected' : '' }}>{{ $sort }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </nav>
                            </form>

                            {{-- check nếu ko có product thì show no data --}}
                            @if (!$products->isEmpty())
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>

                                            <th scope="col">name</th>
                                            {{-- <th scope="col">slug</th> --}}
                                            <th scope="col">thumbnail</th>

                                            <th scope="col">stock</th>
                                            <th scope="col">price</th>
                                            <th scope="col">category</th>
                                            
                                            <th scope="col">status</th>
                                            <th scope="col">is_hot</th>
                                            <th scope="col">action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($products as $product)
                                            <tr> 
                                                <td>{{ $product->name }}</td>
                                                {{-- <td>{{ $product->slug }}</td> --}}
                                                <td>
                                                    @if ($product->thumbnail)
                                                        <img
                                                            class="img-thumbnail" width="200" height="150"src="{{ asset('storage/thumbnail/' . $product->thumbnail->name) }}">
                                                    @else
                                                        <img
                                                            class="img-thumbnail" width="250" height="250"src="{{ asset('img/default/thumbnail-default.jpg') }}">
                                                    @endif
                                                </td>
                                                <td>{{ number_format($product->stock) }}</td>
                                                <td>{{ number_format($product->price) }}</td>
                                                <td>{{ $product->category->name ?? '' }}</td>
                                                <td><input type="checkbox"
                                                        data-url="{{ route('products.update', $product->id) }}"
                                                        name="is_active" class="toggle-active" id="toggle-is-active"
                                                        {{ $product->is_active == 1 ? 'checked' : '' }}></td>
                                                <td><input type="checkbox"
                                                        data-url="{{ route('products.update', $product->id) }}"
                                                        name="is_hot" class="toggle-active" id="toggle-is-hot"
                                                        {{ $product->is_hot === 1 ? 'checked' : '' }}></td>
                                                <td>
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-primary">Edit</i></a>
                                                    {{-- <a
                                                        href="{{ route('products.show', $product->id) }}"class="btn btn-success">View</a> --}}
                                                    <button type="button" class="btn btn-secondary delete-button"
                                                        data-title="{{ $product->name }}"
                                                        data-link="{{ route('products.destroy', $product->id) }}"
                                                        data-toggle="modal" data-target="#deleteForm">
                                                        Delete</button>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                {{ 'data not found' }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        </div>
        <!-- /.card -->

        <!-- Modal delete -->
        <div class="modal fade" id="deleteForm" tabindex="-1" aria-labelledby="deleteFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="#" id="delete-form" method="post">
                        @method('delete')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteFormLabel">Delete product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this product?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-danger">Yes</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection



    @push('custom-js')
        <script>
            // $('.select2').select2();
            // $(document).ready(function () {
            //     $('.delete-button').on('click', (e) => {
            //         const title = $(e.target).data('title')
            //         const link = $(e.target).data('link')
            //         console.log(link)

            //         $('#title').html(title)
            //         $('#delete-form').attr('action', link)
            //     })
            // $(document).ready(function() {
            //     $('.delete-button').on('click', function(e) {
            //         // const title = $(e.target).data('title')
            //         const link = $(this).data('link')
            //         console.log(this);
            //         // $('#title').html(title)
            //         $('#delete-form').attr('action', link)
            //     })
            $(document).ready(function() {
                $('.delete-button').on('click', function(event) {
                    event.preventDefault();

                    var link = $(this).data('link');
                    console.log(link);
                    $('#delete-form').attr('action', link);

                });




                $('#toggle-is-hot').on('click', function() {
                    const url = $(this).data('url');
                    console.log($(this).is(':checked'));
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            is_active: $(this).is(':checked') ? 1 : 0,
                        },
                        dataType: 'json',
                        success: function(data) {
                            toastr.success(data.success)
                        }
                    });
                })
            })
            $(document).ready(function() {
                $('.product-filter').on('change', function() {
                    console.log('hi');
                    $('#form-filter').trigger('submit');
                })
            })
        </script>
    @endpush
