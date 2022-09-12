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

                    <div class="table-responsive table-responsive-data2">
                        <a href="{{ route('admin#orderList') }}" class="text-dark"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>

                        <div class="card mt-4 col-6">
                            <div class="card-header mt-2">
                                <h4><i class="fa-solid fa-clipboard me-2"></i>Order Info</h4>
                                <small class="text-warning"><i class="fa-solid fa-triangle-exclamation me-1"></i>Include Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i>Customer Name</div>
                                    <div class="col">{{ strtoupper($orderLists[0]->user_name) }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order ID</div>
                                    <div class="col">{{ $orderLists[0]->order_code }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-calendar-days me-2"></i>Order date</div>
                                    <div class="col">{{ $orderLists[0]->created_at->format('F-j-Y') }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-sack-dollar me-2"></i>Total Price</div>
                                    <div class="col">{{ $orders->total_price }} kyats</div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orderLists as $orderList)
                                    <tr class="tr-shadow">
                                        <td></td>
                                        <td>{{ $orderList->id }}</td>
                                        <td class="col-2"><img src="{{ asset('storage/'.$orderList->product_image) }}" class=" img-thumbnail shadow-sm"></td>
                                        <td>{{ $orderList->product_name }}</td>
                                        <td>{{ $orderList->quantity }}</td>
                                        <td>{{ $orderList->total }}</td>
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

