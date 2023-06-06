@extends('admin.admin_dashboard')
@section('admin')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Banner</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
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
                            <form id="myForm" method="POST" action="{{ route('update.banner') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $bannerData->id }}">
                                <input type="hidden" name="old_image" value="{{ $bannerData->brand_image }}">
                                <div class="mb-3">
                                    <label class="form-label">Banner Title</label>
                                    <input type="text" id="name" name="banner_title" class="form-control"
                                        value="{{ $bannerData->banner_title }}" placeholder="Banner Title">
                                </div>
                                @error('banner_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">Banner Url</label>
                                    <input type="text" id="slug" name="banner_url" class="form-control"
                                        value="{{ $bannerData->banner_url }}" placeholder="Banner Title">
                                </div>
                                @error('banner_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" name="banner_image" id="image" class="form-control"
                                        value="{{ $bannerData->banner_image }}">
                                </div>
                                @error('banner_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"> </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" src="{{ asset($bannerData->banner_image) }}" alt="Admin"
                                            style="width:100px; height: 100px;">
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary px-5">Update Banner</button>
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
                    brand_name: {
                        required: true,
                    },
                    brand_image: {
                        required: true,
                    },
                },
                messages: {
                    brand_name: {
                        required: 'Please Enter Slider Title',
                    },
                    brand_image: {
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
