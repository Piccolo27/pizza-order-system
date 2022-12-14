@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    @if (session('deleteSuccess'))
                        <div class="col-5 offset-7">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-delete-left"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class=" text-secondary">Search key : <span class=" text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ Route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search"
                                        value="{{ request('key') }}">
                                    <button class=" btn btn-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-5">
                            <h4 class="text-secondary">Total-({{ $admins->total() }})</h4>
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
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr class="tr-shadow">
                                        <td class="col-2">
                                            @if ($admin->image == null)
                                                @if ($admin->gender == 'male')
                                                    <img src="{{ asset('image/default_male_user.jpg') }}"
                                                        class=" img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{ asset('image/default_female_user.jpg') }}"
                                                        class=" img-thumbnail shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $admin->image) }}"
                                                    class=" img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->gender }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>{{ $admin->address }}</td>
                                        <td class="">
                                            <input type="hidden" class="adminId" value="{{ $admin->id }}">
                                            @if (Auth::user()->id != $admin->id)
                                                <select name="role" class="form-select-sm" id="roleChange">
                                                    <option value="admin" selected>Admin</option>
                                                    <option value="user">User</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <div class=" table-data-feature">
                                                @if (Auth::user()->id != $admin->id)
                                                    <a href=" {{ route('admin#delete', $admin->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class=" mt-2">
                            {{ $admins->links() }}
                            {{-- {{ $categories->appends(request()->query())->links() }} --}}
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
        $('#roleChange').change(function() {

            $currentRole = $(this).val();
            $parentNode = $(this).parents('tr');
            $adminId = $parentNode.find('.adminId').val();

            $data = {
                'role': $currentRole,
                'adminId' : $adminId
            }

            $.ajax({
                type: 'get',
                url: '/admin/ajax/change/role',
                data: $data,
                dataType: 'json',
            })
            location.reload();
        })
    </script>
@endsection
