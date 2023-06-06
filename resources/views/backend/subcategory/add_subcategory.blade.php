@extends('admin.admin_dashboard')
@section('admin')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">SubCategory</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add SubCategory</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button"
                            class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <form id="myForm" method="post" action="{{ route('store.sub_category') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <select name="category_id" id="categorySelect" class="form-select mb-3"
                                        aria-label="Default select example">
                                        <option value="{{ old('category_id') }}">Option select this menu</option>
                                        @foreach ($categories as $item)
                                            {{-- <option value="{{ $item->id }}">{{ $item->category_name }}</option> --}}
                                            <option value="{{ $item->id }}"
                                                {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="errorCategory" style="color: red; display: none;">Vui lòng chọn một danh
                                        mục.</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SubCategory Name</label>
                                    <input type="text" id="name" name="subcategory_name" class="form-control"
                                        value="{{ old('subcategory_name') }}" placeholder="SubCategory Name">
                                </div>
                                @error('subcategory_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">SubCategory Slug</label>
                                    <input type="text" id="slug" name="subcategory_slug" class="form-control"
                                        value="{{ old('subcategory_slug') }}" placeholder="ubCategory Slug">
                                    @error('subcategory_slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary px-5" onclick="validateForm()">Add
                                        SubCategory</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    category_name: {
                        required: true,
                    },
                },
                messages: {
                    category_name: {
                        required: 'Please Enter Category Name',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Lắng nghe sự kiện khi người dùng nhập dữ liệu vào trường tên
            $('#name').on('input', function() {
                var name = $(this).val();
                var slug = slugify(name);
                $('#slug').val(slug);
            });

            // Hàm slugify
            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                    .replace(/[^\w\-]+/g, '') // Xóa các ký tự không hợp lệ
                    .replace(/\-\-+/g, '-') // Xóa các dấu gạch ngang liên tiếp
                    .replace(/^-+/, '') // Xóa dấu gạch ngang ở đầu chuỗi
                    .replace(/-+$/, ''); // Xóa dấu gạch ngang ở cuối chuỗi
            }
        });
    </script>

    <script>
        function validateForm() {
            var categorySelect = document.getElementById('categorySelect');
            var errorCategory = document.getElementById('errorCategory');

            if (categorySelect.value === '') {
                errorCategory.style.display = 'inline';
                return false; // Ngăn form được gửi đi
            }

            // Nếu không có lỗi, cho phép gửi form
            return true;
        }
    </script>
@endsection
