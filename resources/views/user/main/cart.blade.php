@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable" <thead
                    class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr id="theTr">
                                <input type="hidden" value="{{ $c->pizza_price }}" id="price">
                                <td class=" align-middle"><img src="{{ asset('storage/' . $c->pizza_image) }}"
                                        class=" img-thumbnail shadow-sm" alt="" style="width: 70px;">
                                </td>
                                <td class="align-middle">
                                    {{ $c->pizza_name }}
                                    <input type="hidden" class="orderId" value="{{ $c->id }}">
                                    <input type="hidden" class="productId" value="{{ $c->product_id }}">
                                    <input type="hidden" class="userId" value="{{ $c->user_id }}">
                                </td>
                                <td class="align-middle" id="pizzaPrice">{{ $c->pizza_price }} kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $c->quantity }}" id="quantity">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle col-3" id="total">{{ $c->pizza_price * $c->quantity }} kyats
                                </td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">${{ $totalPrice }} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 3000 }} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">
                            Proceed To Checkout
                        </button>
                        <button class="btn btn-block btn-danger font-weight-bold mb-3 py-3" id="clearBtn">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scriptSource')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        $('#orderBtn').click(function() {
            $orderList = [];
            $random1 = Math.floor(Math.random() * 1000000001);
            $random2 = Math.floor(Math.random() * 1000000001);

            $('#dataTable tbody #theTr').each(function(index, row) {
                $orderList.push({
                    'user_id': $(row).find('.userId').val(),
                    'product_id': $(row).find('.productId').val(),
                    'quantity': $(row).find('#quantity').val(),
                    'total': $(row).find('#total').text().replace('kyats', '') * 1,
                    'order_code': $random1 + $random2,
                });
            });

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/order',
                data: Object.assign({}, $orderList),
                datatype: 'json',
                success: function(response) {
                    if (response.status == "true") {
                        window.location.href = "http://localhost:8000/user/homePage";
                    }
                }
            })
        })

        //when clear cart button click
        $('#clearBtn').click(function() {
            $('#dataTable tbody #theTr').remove();
            $('#subTotalPrice').html("0 kyats");
            $('#finalPrice').html('3000 kyats');

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/clear/cart',
                datatype: 'json',
            })
        })

        //remove button click
        $('.btnRemove').click(function() {
            $parentNode = $(this).parents('tr');
            $productId = $parentNode.find('.productId').val();
            $orderId = $parentNode.find('.orderId').val();

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/clear/current_product',
                data: {
                    'productId': $productId ,
                    'orderId' : $orderId
                },
                dataType: 'json',
            })
            $parentNode.remove();

            $totalPrice = 0;
            $('#dataTable tbody #theTr').each(function(index, row) {
                $totalPrice += Number($(row).find('#total').text().replace('kyats', ''));
            });

            $('#subTotalPrice').html(`${$totalPrice} kyats`);
            $('#finalPrice').html(`${$totalPrice + 3000} kyats`);

        })
    </script>
@endsection
