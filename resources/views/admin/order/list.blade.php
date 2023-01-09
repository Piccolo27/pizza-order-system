@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-5 offset-7">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-delete-left"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin#changeStatus') }}" method="get">
                        @csrf
                        <div class="input-group mb-3">
                            <select name="orderStatus" class="form-select col-2">
                                <option value="">All</option>
                                <option value="0" @if(request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if(request('orderStatus') == '1') selected @endif>Success</option>
                                <option value="2" @if(request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>
                            <button type="submit" class="btn btn-sm bg-dark text-white"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <div class=" input-group-append ms-3">
                                <span class=" input-group-text">
                                    <i class="fa-solid fa-database mr-2"></i>{{ count($orders) }}
                                </span>
                            </div>
                        </div>
                    </form>



                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orders as $order)
                                    <tr class="tr-shadow">
                                        <input type="hidden" class="orderId" value="{{ $order->id }}">
                                        <td class="">{{ $order->user_id }}</td>
                                        <td class="">{{ $order->user_name }}</td>
                                        <td class="">{{ $order->created_at->format('F-j-Y') }}</td>
                                        <td class="">
                                            <a href="{{ route('admin#listInfo',$order->order_code) }}">{{ $order->order_code }}</a>
                                        </td>
                                        <td class="">{{ $order->total_price }} Kyats</td>
                                        <td class="">
                                            <select name="status" class="form-select statusChange">
                                                <option value="0" @if ($order->status == 0) selected @endif>
                                                    Pending</option>
                                                <option value="1" @if ($order->status == 1) selected @endif>
                                                    Success</option>
                                                <option value="2" @if ($order->status == 2) selected @endif>
                                                    Reject</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://localhost:8000/order/ajax/status',
            //         data: {
            //             'status': $status,
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $list = '';

            //             for ($i = 0; $i < response.length; $i++) {

            //                 $months = ["January", "February", "March", "April", "May", "June",
            //                     "July", "August", "September", "October", "November",
            //                     "December"
            //                 ];
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $months[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
            //                     "-" + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `
            //                         <select name="status" class="form-select statusChange">
            //                             <option value="0" selected>Pending</option>
            //                             <option value="1">Success</option>
            //                             <option value="2">Reject</option>
            //                         </select>
            //                     `;
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `
            //                         <select name="status" class="form-select statusChange">
            //                             <option value="0">Pending</option>
            //                             <option value="1" selected>Success</option>
            //                             <option value="2">Reject</option>
            //                         </select>
            //                     `;
            //                 } else {
            //                     $statusMessage = `
            //                         <select name="status" class="form-select statusChange">
            //                             <option value="0">Pending</option>
            //                             <option value="1">Success</option>
            //                             <option value="2" selected>Reject</option>
            //                         </select>
            //                     `;
            //                 }

            //                 $list += `
            //                     <tr class="tr-shadow">
            //                         <input type="hidden" class="orderId" value="${ response[$i].id }">
            //                         <td class=""> ${response[$i].user_id} </td>
            //                         <td class=""> ${response[$i].user_name} </td>j
            //                         <td class=""> ${$finalDate}</td>
            //                         <td class=""> ${response[$i].order_code} </td>
            //                         <td class=""> ${response[$i].total_price}  Kyats</td>
            //                         <td class="">${$statusMessage}</td>
            //                     </tr>
            //                     `;
            //             }
            //             $('#dataList').html($list);
            //         }
            //     })
            // })

            //change status
            $('.statusChange').change(function() {

                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('.orderId').val();

                $data = {
                    'status': $currentStatus,
                    'orderId': $orderId,
                };

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
