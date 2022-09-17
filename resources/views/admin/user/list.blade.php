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
                                <i class="fa-solid fa-delete-left me-2"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close">
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="row my-2">
                        <div class="col-5">
                            <h4 class="text-secondary">Total-({{ $users->total() }})</h4>
                        </div>
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/default_male_user.jpg') }}"
                                                        class=" img-thumbnail shadow-sm align-self-center">
                                                @else
                                                    <img src="{{ asset('image/default_female_user.jpg') }}"
                                                        class=" img-thumbnail shadow-sm align-self-center">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}"
                                                    class="img-thumbnail shadow-sm align-self-center" />
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td class="col-3">
                                            <input type="hidden" class="userId" value="{{ $user->id }}">
                                            <select class=" form-select roleChange">
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ Route('admin#userDelete',$user->id) }}">
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
                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>
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
        $('.roleChange').change(function() {
            $currentRole = $(this).val();
            $parentNode = $(this).parents('tr');
            $userId = $parentNode.find('.userId').val();

            $data = {
                'role': $currentRole,
                'userId': $userId
            }

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/change/role',
                data: $data,
                dataType: 'json',
            })
            location.reload();
        })
    </script>
@endsection
