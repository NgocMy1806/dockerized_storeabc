@extends('user.layout.layout')
@section('content')
    <script src="https://js.stripe.com/v3/"></script>
    <div class="container">
        <h1>Shopping Cart: ${{$total}}</h1>
        @if (Session::has('cart'))
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td><img width="50" height="50"
                                    class="img-thumbnail"src="{{ asset('storage/thumbnail/' . $item['thumbnail']) }}"></td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] * $item['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        @else
            <p>Your cart is empty</p>
        @endif
        <br>
        <h1>Delivery information</h1>
        <form method="POST" action="{{ route('checkout') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2" for="name">Name</label>
                <div class="col-sm-4">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                        required>
                </div>


                <label class="col-sm-2" for="email">Email Address</label>
                <div class="col-sm-4">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="country" class="col-sm-2 col-form-label text-md-right">{{ __('Country') }}</label>

                <div class="col-sm-4">
                    <select id="country" class="form-control @error('country') is-invalid @enderror" name="country"
                        required>
                        <option value="">-- Select Country --</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                </div>


                <label for="state" class="col-sm-2 col-form-label text-md-right">{{ __('State') }}</label>

                <div class="col-sm-4">
                    <select id="state" class="form-control @error('state') is-invalid @enderror" name="state"
                        required>
                        <option value="">-- Select State --</option>
                    </select>

                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="city" class="col-sm-2 col-form-label text-md-right">{{ __('City') }}</label>

                <div class="col-sm-4">
                    <select id="city" class="form-control @error('city') is-invalid @enderror" name="city" required>
                        <option value="">-- Select City --</option>
                    </select>
                </div>

                <label for="address" class="col-sm-2 col-form-label text-md-right">{{ __('Address') }}</label>

                <div class="col-sm-4">
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                        name="address" value="{{ old('address') }}" required>
                </div>
            </div>
    
    <button type="submit"class="btn btn-primary" id="checkout-button">Checkout</button>
    </form>
    </section>
@endsection
@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#country').on('change', function() {
                var country_id = $(this).val();
                var url = "{{ route('getStates', ':id') }}".replace(':id', country_id);
                if (country_id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var states = data.states;
                            var $stateSelect = $('#state');

                            $stateSelect.empty();
                            $stateSelect.append('<option value="">Select State</option>');

                            $.each(states, function(index, state) {
                                $stateSelect.append('<option value="' + state.id +
                                    '">' + state.state_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty();
                    $('#state').append('<option value="">Select a state</option>');
                }
            });
            $('#state').on('change', function() {
                var state_id = $(this).val();
                console.log(state_id);
                var url = "{{ route('getCities', ':id') }}".replace(':id', state_id);
                if (state_id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var cities = data.cities;
                            console.log(cities);
                            var $citySelect = $('#city');

                            $citySelect.empty();
                            $citySelect.append('<option value="">Select City</option>');

                            $.each(cities, function(index, city) {
                                $citySelect.append('<option value="' + city.id +
                                    '">' + city.city_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city').empty();
                    $('#city').append('<option value="">Select a city</option>');
                }
            });
        });
    </script>
@endpush
