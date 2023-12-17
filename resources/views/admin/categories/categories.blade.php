@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <h4 class="card-title">Kategori Produk</h4>
                        <!-- <p class="card-description">
                        Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-primary">Tambah Kategori</a>                       
                    <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Nama Kategori
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
                                  @foreach($categories as $category)
                                    @if(isset($category['parentcategory']['category_name'])&&!empty($category['parentcategory']['category_name']))
                                        @php $parent_category = $category['parentcategory']['category_name']; @endphp
                                    @else
                                        @php $parent_category = "Root"; @endphp
                                    @endif
                                    <tr>
                                        <td>
                                            {{ $category['id'] }}
                                        </td>
                                        <td>
                                            {{ $category['category_name'] }}
                                        </td>
                                        <td>
                                            @if($category['status']==1)
                                              <a class="updateCategoryStatus" id="category-{{ $category['id'] }}" category_id="{{ $category['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Aktif"></i></a>
                                            @else
                                              <a class="updateCategoryStatus" id="category-{{ $category['id'] }}" category_id="{{ $category['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Non-Aktif"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-category/'.$category['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <?php /* <a title="Category" class="confirmDelete" href="{{ url('admin/delete-category/'.$category['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */ ?>
                                            <a href="javascript:void(0)" class="confirmDelete" module="category" moduleid="{{ $category['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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