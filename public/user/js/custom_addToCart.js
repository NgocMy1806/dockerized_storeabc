
// $(document).ready(function() {
//     $('.add-to-cart').click(function(event) {
//         event.preventDefault();

//         var productId = $(this).data('product-id');
//         var url = "{{ route('AddToCart', ':productId') }}".replace(':productId', productId);
//         console.log(productId);
//         $.ajax({
//             url: url,
//             type: "POST",
//             dataType: 'JSON',
//             data: {
//                 _token: '{{ csrf_token() }}',
//                 id: productId
//             },
//             success: function(response) {

//                 $('#cart-total').html('$' + response.total.toFixed(2));
//                 $('#cart-count').text(response.cartCount);
//                 alert('Add to cart successfully!');
//                 // update the cart count in the session
//                 sessionStorage.setItem('cartCount', response.cartCount);
//             },
//             error: function(response) {
//                 console.log(response);
//                 alert('Error occurred while adding the product to the cart!');
//             }
//         });
//     });
// });
