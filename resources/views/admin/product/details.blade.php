@extends("admin.layouts.master")

@section("title","Category List Page")

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2"><i class="fa-solid fs-4 fa-pizza-slice me-2"></i>{{ $pizza->name }}</h3>
                            </div>
                            <div class="row">
                                <div class="col-6 offset-6">
                                    @if (session('updateSuccess'))
                                        <div class="">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-user-check me-2"></i> {{ session('updateSuccess') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1">
                                    <img src="{{ asset('storage/'.$pizza->image) }}" class="img-thumbnail shadow-sm mt-5" />
                                </div>
                                <div class="col-7 offset-1">
                                    <span class="my-3 btn btn-white text-dark"> <i class="fa-solid fs-4 fa-dollar-sign me-2"></i> {{ $pizza->price }} </span>
                                    <span class="my-3 btn btn-white text-dark"> <i class="fa-solid fs-4 fa-clock me-2"></i> {{ $pizza->waiting_time }} min</span>
                                    <span class="my-3 btn btn-white text-dark"> <i class="fa-solid fs-4 fa-eye me-2"></i> {{ $pizza->view_count }}</span>
                                    <span class="my-3 btn btn-white text-dark"> <i class="fa-solid fa-clone"></i> {{ $pizza->category_name }}</span>
                                    <span class="my-3 btn btn-white text-dark"> <i class="fa-solid fs-4 fa-user-clock me-2"></i> {{ $pizza->created_at->format('j-F-Y') }}</span>
                                    <div class="my-3"> <i class="fa-solid fs-4 fa-file-lines me-2"></i>Details</div>
                                    <div class="my-3">{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


