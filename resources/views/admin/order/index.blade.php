@extends('admin.layout.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List orders </h1>
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
                            <div class="card-title">List orders </div>

                        </div>
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert-success">{{ session()->get('success') }}</div>
                            @endif
                            {{-- <a href="{{ route('products.create') }}" class="btn btn-outline-info">Add order</a> --}}

                            {{-- check nếu ko có product thì show no data --}}
                            @if (!$orders->isEmpty())
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>

                                            <th scope="col">ID</th>
                                            {{-- <th scope="col">slug</th> --}}
                                            <th scope="col">Products</th>

                                            <th scope="col">Order status</th>
                                            <th scope="col">Payment statu</th>
                                            <th scope="col">Payment method</th>
                                            <th scope="col">Total amount</th>
                                            
                                            <th scope="col">Customer name</th>
                                            
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($orders as $order)
                                            <tr> 
                                                <td>{{ $order->id }}</td>
                                                {{-- <td>{{ $product->slug }}</td> --}}
                                              
                                                <td>{{ number_format($order->total_amount) }}</td>
                                             
                                                <td>{{ $order->order_status }}</td>
                                                {{-- <td><input type="checkbox"
                                                        data-url="{{ route('order.update', $order->id) }}"
                                                        name="payment_status" class="toggle-active" id="toggle-is-active"
                                                        {{ $order->payment_status == 'paid' ? 'checked' : '' }}></td> --}}
                                                <td>{{ $order->payment_method }}</td>
                                                <td>{{ $order->total_amount }}</td>
                                                <td>{{ $order->customer->name }}</td>
                                                <td>
                                                    {{-- <a href="{{ route('order.show', $order->id) }}"
                                                        class="btn btn-primary">View detail</i></a>
                                                 
                                                    <button type="button" class="btn btn-secondary delete-button"
                                                        data-title="{{ $order->name }}"
                                                        data-link="{{ route('order.destroy', $order->id) }}"
                                                        data-toggle="modal" data-target="#deleteForm">
                                                        Delete</button> --}}

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
                {{-- {{ $orders->links() }} --}}
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
