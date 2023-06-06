@extends('admin.admin_dashboard')
@section('admin')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Slider</li>
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
                            <form id="myForm" method="POST" action="{{ route('store.slider') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Slider Title</label>
                                    <input type="text" name="slider_title" class="form-control"
                                        value="{{ old('slider_title') }}" placeholder="Slider Title">
                                </div>
                                @error('slider_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">Short Title</label>
                                    <input type="text" name="short_title" class="form-control"
                                        value="{{ old('short_title') }}" placeholder="Short Title">
                                </div>
                                @error('short_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">Slider Image</label>
                                    <input type="file" name="slider_image" id="image" class="form-control"
                                        value="{{ old('slider_image') }}">
                                </div>
                                @error('slider_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"> </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin"
                                            style="width:100px; height: 100px;">
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary px-5">Add Slider</button>
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
                    slider_title: {
                        required: true,
                    },
                    short_title: {
                        required: true,
                    },
                },
                messages: {
                    slider_title: {
                        required: 'Please Enter Slider Title',
                    },
                    short_title: {
                        required: 'Please Enter Short Title',
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
@endsection
