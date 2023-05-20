@extends('user.layout.layout')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                User information
            </div>
            <div class="card-body">
                {{-- <p><strong>Name:</strong> {{ session()->get('userName') }}</p>
                <p><strong>Email:</strong> {{ session()->get('userEmail') }}</p>
                <p><strong>Address:</strong> {{ session()->get('userAddress') }}</p> --}}
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Order history
            </div>
            <div class="card-body">
                @foreach ($orders as $order)
                    <table class="body-wrap">
                        <tbody>
                            <tr>
                                <td></td>
                                <td class="container" width="600">
                                    <div class="content">
                                        <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td class="content-wrap aligncenter">
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                
                                                                    <td class="content-block">
                                                                        <table class="invoice">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>June
                                                                                        01 2015 <br>Invoice #12345<br></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table class="invoice-items"
                                                                                            cellpadding="0" cellspacing="0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>Service 1</td>
                                                                                                    <td class="alignright">$
                                                                                                        20.00</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Service 2</td>
                                                                                                    <td class="alignright">$
                                                                                                        10.00</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Service 3</td>
                                                                                                    <td class="alignright">$
                                                                                                        6.00</td>
                                                                                                </tr>
                                                                                                <tr class="total">
                                                                                                    <td class="alignright"
                                                                                                        width="80%">Total
                                                                                                    </td>
                                                                                                    <td class="alignright">$
                                                                                                        36.00</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                      
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
