<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Completed</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <p>Hello {{ $customer->name }},</p>
                        <p>Your order with ID {{ $order->id }} has been completed. Thank you for your purchase!</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th style="width: 250px;">Product</th>
                                    <th style="width: 150px;">Quantity</th>
                                    <th  style="width: 150px;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $orderDetail)
                                    <tr>
                                        <td  style="width: 250px;text-align: center;">{{ $orderDetail->product->name }}</td>
                                        <td style="width: 150px;text-align: center;">{{ $orderDetail->quantity }}</td>
                                        <td style="width: 150px;text-align: center;">$ {{ $orderDetail->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p>Total: $ {{ $order->total_amount }}</p>
                    </div>
                    <p>Thank you for shopping with us.</p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
