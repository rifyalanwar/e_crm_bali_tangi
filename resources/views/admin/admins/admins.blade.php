@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pengaturan Admin</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-admins') }}" class="btn btn-block btn-primary">Tambah Admin</a>
                        <div class="table-responsive pt-3">
                            <table id ="admins" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Nama
                                        </th>
                                        <th>
                                            Role
                                        </th>
                                        <th>
                                            Nomor Telepon
                                        </th>
                                        <th>
                                            E-mail
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($admins as $admin)
                                    <tr>
                                        <td>
                                            {{ $admin['id'] }}
                                        </td>
                                        <td>
                                            {{ $admin['name'] }}
                                        </td>
                                        <td>
                                            {{ $admin['type'] }}
                                        </td>
                                        <td>
                                            {{ $admin['mobile'] }}
                                        </td>
                                        <td>
                                            {{ $admin['email'] }}
                                        </td>
                                        <td>
                                            @if($admin['status']==1)
                                              <a class="updateAdminStatus" id="admin-{{ $admin['id'] }}" admin_id="{{ $admin['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Aktif"></i></a>
                                            @else
                                              <a class="updateAdminStatus" id="admin-{{ $admin['id'] }}" admin_id="{{ $admin['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Non-aktif"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="confirmDelete" module="admin" moduleid="{{ $admin['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
                                        </td>
                                    </tr>
                                   @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection