@extends('admin.admin_dashboard')
@section('admin')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
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
                            <form id="myForm" method="post" action="{{ route('update.category') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $categoriesData->id }}">
                                <input type="hidden" name="old_image" value="{{ $categoriesData->category_image }}">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" id="name" name="category_name" class="form-control"
                                        value="{{ $categoriesData->category_name }}" placeholder="Short Title">
                                </div>
                                @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">Category Slug</label>
                                    <input type="text" id="slug" name="category_slug" class="form-control"
                                        value="{{ $categoriesData->category_slug }}" placeholder="Short Title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category Image</label>
                                    <input type="file" name="category_image" id="image" class="form-control"
                                        value="{{ $categoriesData->category_image }}">
                                    {{-- @if ($categoriesData->category_image)
                                        <input type="hidden" name="category_image"
                                            value="{{ $categoriesData->category_image }}">
                                        <img src="{{ asset($categoriesData->category_image) }}" alt="Category Image"
                                            width="100">
                                    @endif --}}
                                </div>
                                @error('category_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"> </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" src="{{ asset($categoriesData->category_image) }}"
                                            alt="Admin" style="width:100px; height: 100px;">
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary px-5">Update Category</button>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
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
@endsection
