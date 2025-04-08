@extends('layout.adm')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Category
                <small>List</small>
            </h1>

            <!-- Thêm dropdown để lọc theo status -->
            <div class="filter-section" style="margin-bottom: 20px;">
                <form method="GET" action="{{ route('admin.cate') }}">
                    <div class="form-group">
                        <label for="status">Lọc theo trạng thái:</label>
                        <select name="status" id="status" onchange="this.form.submit()" class="form-control" style="width: 200px; display: inline-block;">
                            <option value="">Tất cả</option>
                            <option value="1" {{ $status == '1' ? 'selected' : '' }}>Hiện</option>
                            <option value="0" {{ $status == '0' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bảng danh sách danh mục -->
        <div class="col-lg-12">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category Parent</th>
                        <th>Status</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                    <tr class="{{ $loop->odd ? 'odd' : 'even' }} gradeX" align="center">
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->parent_id)
                            {{ $category->parent->name ?? 'Không tồn tại' }}
                            @else
                            None
                            @endif
                        </td>
                        <td>
                            @if($category->status == 1)
                            Hiện
                            @else
                            Ẩn
                            @endif
                        </td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ route('admin.category.delete', $category->id) }}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ route('admin.category.edit', $category->id) }}"> Edit</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" align="center">Không có danh mục nào.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection