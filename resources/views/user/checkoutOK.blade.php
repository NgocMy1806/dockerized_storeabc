{{-- @extends('user.layout.layout')
@section('content')

@endsection --}}

<!DOCTYPE html>
<html>

<head>
    <title>Ordered Successfully</title>
</head>

<body>
   
  @if ($payment_method === 'stripe')
  <div class="alert-success">
      <h1>Payment Successful</h1>
      <p>Thank you for your purchase. Your payment has been successfully processed.</p>
  </div>
@elseif ($payment_method === 'bank')
  <div class="alert-success">
      <h1>Plese process bank transfer to complete order</h1>
      <div class="container" style="display:flex">
                <div class="row" style="display: flex;">
                    <div class="col-md-8" style="width: 500px">
                        <h2>Bank Transfer Information</h2>
                        <table class="table table-bordered">
                            <tr>
                                <td>Bank Account Name:</td>
                                <td>store Wab</td>
                            </tr>
                            
                            <tr>
                                <td>Bank Number:</td>
                                <td>012346868686</td>
                            </tr>
                            <tr>
                                <td>Bank Name:</td>
                                <td>HSBC</td>
                            </tr>
                            <tr>
                                <td>Transfer Content:</td>
                                <td>Order AB123</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h2>QR Code</h2>
                        <img src="{{ asset('/user/images/icon-256x256.png') }}" alt="QR Code" width="165" height="165">
                    </div>
                </div>
            </div>
        </div>
    {{-- @elseif( session()->get('payment_method')==='COD' ) --}}
    @elseif ($payment_method === 'COD')
        <div class="alert-success">
            <h1>Order Successful</h1>
            <p>Your order will be deliverd in 3 days</p>
        </div>
    @endif

   <h3> <a href={{ route('index') }}> Back to toppage </a></h3>
</body>

</html>

