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
                            <a href="{{ route('admin#list') }}">
                                <div class="ms-5">
                                    <i class="fa-solid fa-arrow-left text-dark"></i>
                                </div>
                            </a>
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Role</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#changeRole',$account->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            @if ($account->gender == 'male')
                                                <img src="{{ asset('image/default_male_user.jpg') }}" class=" img-thumbnail">
                                            @else
                                                <img src="{{ asset('image/default_female_user.jpg') }}" class=" img-thumbnail">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'.$account->image) }}" class=" img-thumbnail" >
                                        @endif
                                    </div>
                                    <div class="col-6 ">
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" value="{{ old('name',$account->name) }}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin name" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-1">Role</label>
                                            <select name="role" class="form-select">
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text" value="{{ old('email',$account->email) }}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Email" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="number" value="{{ old('phone',$account->phone) }}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Phone" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-1">Gender</label>
                                            <select name="gender" class=" form-select" disabled>
                                                <option value="male" @if($account->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if($account->gender == 'female') selected @endif>Female</option>
                                                <option value="other" @if($account->gender == 'other') selected @endif>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control" cols="30" rows="10" placeholder="Enter Admin Address" disabled>{{ old('address',$account->address) }}</textarea>
                                        </div>
                                        <div class="text-end">
                                            <button class=" btn bg-dark text-white" type="submit">
                                                Update <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


