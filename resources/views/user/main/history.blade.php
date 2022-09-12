@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" style="height: 500px">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable" <thead
                    class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">{{ $order->created_at->format('F-j-Y') }}</td>
                                <td class="align-middle">{{ $order->order_code }}</td>
                                <td class="align-middle">{{ $order->total_price }}</td>
                                <td class="align-middle">
                                    @if ($order->status == 0)
                                        <span class="text-warning"><i class="fa-solid fa-user-clock me-1"></i>Pending</span>
                                    @elseif ($order->status == 1)
                                        <span class="text-success"><i class="fa-solid fa-check me-1"></i>Success</span>
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>Reject</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
