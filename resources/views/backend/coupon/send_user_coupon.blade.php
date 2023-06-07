@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Coupon </div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Send User Coupon </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">

                </div>
            </div>
            <!--end breadcrumb-->
            <div class="container">
                <div class="main-body">
                    <div class="row">

                        <div class="col-lg-10">
                            <div class="card">
                                <div class="card-body">

                                    <form id="myForm" method="post" action="{{ route('admin.send.coupon.post') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">User Name</h6>
                                            </div>
                                            <select name="name" id="categorySelect" class="form-select mb-3"
                                                aria-label="Default select example">
                                                <option value="{{ old('name') }}">Choose User </option>
                                                @foreach ($users as $user)
                                                    {{-- <option value="{{ $item->id }}">{{ $item->category_name }}</option> --}}
                                                    <option value="{{ $user->id }}"
                                                        {{ old('name') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Coupon</h6>
                                            </div>
                                            <select name="coupon_name" id="categorySelect" class="form-select mb-3"
                                                aria-label="Default select example">
                                                <option value="">Choose Coupon </option>
                                                @foreach ($coupons as $coupon)
                                                    <option value="{{ $coupon->id }}">{{ $coupon->coupon_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary px-5">Send Coupon</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    coupon_name: {
                        required: true,
                    },
                    coupon_discount: {
                        required: true,
                    },
                },
                messages: {
                    coupon_name: {
                        required: 'Please Enter Coupon Name',
                    },
                    coupon_discount: {
                        required: 'Please Enter Coupon Discount',
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
@endsection
