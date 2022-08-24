@extends("admin.layouts.master")

@section("title","Category List Page")

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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ Route('product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-5 offset-7">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-delete-left"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class=" text-secondary">Search key : <span class=" text-danger">{{ request('key') }}</span></h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ Route('product#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search" value="{{ request('key') }}">
                                    <button class=" btn btn-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-5">
                            <h4 class="text-secondary">Total-({{ $pizzas->total() }})</h4>
                        </div>
                    </div>

                    @if (count($pizzas) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pizzas as $pizza)
                                        <tr class="tr-shadow">
                                            <td class=" col-2"><img src="{{ asset('storage/'.$pizza->image) }}" class=" img-thumbnail shadow-sm"></td>
                                            <td>{{ $pizza->name }}</td>
                                            <td>{{ $pizza->price }}</td>
                                            <td>{{ $pizza->category_name }}</td>
                                            <td><i class="fa-solid fa-eye"></i> {{ $pizza->view_count }}</td>
                                            <td class=" col-2">
                                                <div class="table-data-feature">
                                                    <a href="{{ route('product#details',$pizza->id) }}">
                                                        <button class="item me-2 me-1" data-toggle="tooltip" data-placement="top" title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#editPage',$pizza->id) }}">
                                                        <button class="item me-2 me-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#delete',$pizza->id) }}">
                                                        <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class=" mt-2">
                                {{ $pizzas->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class=" text-secondary text-center mt-5">There is no Pizza Here!</h3>
                    @endif

                <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


