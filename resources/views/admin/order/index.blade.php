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
                                            <th scope="col">Order status</th>
                                            <th scope="col">Payment status</th>
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
                                                <td>
                                                    <select name="order_status" id="order_status" class="order_status"
                                                        data-url="{{ route('orders.update', $order->id) }}">
                                                        <option value="pending"
                                                            @if ($order->order_status == 'pending') selected @endif>Pending
                                                        </option>
                                                        <option value="shipping"
                                                            @if ($order->order_status == 'shipping') selected @endif>Shipping
                                                        </option>
                                                        <option value="completed"
                                                            @if ($order->order_status == 'completed') selected @endif>Completed
                                                        </option>
                                                    </select>
                                                </td>
                                                <td><input type="checkbox"
                                                        data-url="{{ route('orders.update', $order->id) }}"
                                                        name="payment_status" class="toggle-payment-status"
                                                        id="toggle-payment-status"
                                                        {{ $order->payment_status == 'paid' ? 'checked' : '' }}></td>
                                                <td>{{ $order->payment_method }}</td>
                                                <td>{{ number_format($order->total_amount) }}</td>
                                                <td>{{ $order->customer->name }}</td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                        class="btn btn-primary">View</i></a>
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
                {{ $orders->links() }}
            </div>
        </div>
        <!-- /.card -->

       
    @endsection

    @push('custom-js')
        <script>
            $(document).ready(function() {
                $('.toggle-payment-status').on('change', function() {
                    const url = $(this).data('url');
                    console.log($(this).is(':checked'));
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            payment_status: $(this).is(':checked') ? 'paid' : 'unpaid',
                        },
                        dataType: 'json',
                        success: function(data) {
                            toastr.success(data.success)
                        }
                    });
                })
            })

            $(document).ready(function() {
                $('.order_status').on('change', function() {
                    const url = $(this).data('url');
                    console.log($(this).val());
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_status: $(this).val(),
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
