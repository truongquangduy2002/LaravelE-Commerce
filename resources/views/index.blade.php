@extends('frontend.master_dashboard')
@section('dashboard')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 m-auto">
                        <div class="row">
                            @include('frontend.body.dashboard_sidebar_menu')
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                        aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Hello {{ $userData->name }}!</h3>
                                                <br>
                                                <img id="showImage"
                                                    src="{{ !empty($userData->photo) ? url('upload/user_images/' . $userData->photo) : url('upload/no_image.jpg') }}"
                                                    alt="User" class="rounded-circle p-1 bg-primary" width="110"
                                                    height="110">
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    From your account dashboard. you can easily check &amp; view your <a
                                                        href="#">recent orders</a>,<br />
                                                    manage your <a href="#">shipping and billing addresses</a>
                                                    and <a href="#">edit your password and account details.</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Your Orders</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>#1357</td>
                                                                <td>March 45, 2020</td>
                                                                <td>Processing</td>
                                                                <td>$125.00 for 2 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2468</td>
                                                                <td>June 29, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$364.00 for 5 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2366</td>
                                                                <td>August 02, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$280.00 for 3 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="track-orders" role="tabpanel"
                                        aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and
                                                    press "Track" button. This was given to you on your receipt and in
                                                    the confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#"
                                                            method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id"
                                                                    placeholder="Found in your order confirmation email"
                                                                    type="text" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email"
                                                                    placeholder="Email you used during checkout"
                                                                    type="email" />
                                                            </div>
                                                            <button class="submit submit-auto-width"
                                                                type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel"
                                        aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h3 class="mb-0">Billing Address</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            3522 Interstate<br />
                                                            75 Business Spur,<br />
                                                            Sault Ste. <br />Marie, MI 49783
                                                        </address>
                                                        <p>New York</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            4299 Express Lane<br />
                                                            Sarasota, <br />FL 34249 USA <br />Phone: 1.941.227.4444
                                                        </address>
                                                        <p>Sarasota</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                        aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">

                                                <form method="POST" action="{{ route('user.profile.store') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>User Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="username"
                                                                type="text" value="{{ $userData->username }}" />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Full Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="name"
                                                                value="{{ $userData->name }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Email <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="email"
                                                                type="text" value="{{ $userData->email }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Phone <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="phone"
                                                                type="text" value="{{ $userData->phone }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Address <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="address"
                                                                type="text" value="{{ $userData->address }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>User Photo <span class="required">*</span></label>
                                                            <input class="form-control" name="photo" type="file"
                                                                id="image" />
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label> <span class="required">*</span></label>
                                                            <img id="showImages"
                                                                src="{{ !empty($userData->photo) ? url('upload/user_images/' . $userData->photo) : url('upload/no_image.jpg') }}"
                                                                alt="User" class="rounded-circle p-1 bg-primary"
                                                                style="width:100px; height: 100px;">
                                                        </div>



                                                        <div class="col-md-12">
                                                            <button type="submit"
                                                                class="btn btn-fill-out submit font-weight-bold"
                                                                name="submit" value="Submit">Save Change</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="change-password" role="tabpanel"
                                        aria-labelledby="change-password-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Change Password</h3>
                                            </div>

                                            <!-- Kiểm tra và hiển thị lỗi cho trường "Old Password" -->
                                            @if ($errors->has('old_password'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('old_password') }}
                                                </div>
                                            @endif

                                            <!-- Kiểm tra và hiển thị lỗi cho trường "New Password" -->
                                            @if ($errors->has('new_password'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('new_password') }}
                                                </div>
                                            @endif

                                            <!-- Kiểm tra và hiển thị lỗi cho trường "CofirmPassword" -->
                                            @if ($errors->has('confirm_password'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('confirm_password') }}
                                                </div>
                                            @endif

                                            <div id="error_message" style="color: red; display: none;"></div>

                                            <div class="card-body contact-from-area">

                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form id="passwordForm" class="contact-form-style mt-30 mb-50"
                                                            action="{{ route('user.change.password') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="input-style mb-20">
                                                                <label>Old Password</label>
                                                                <input name="old_password" placeholder="Old Password"
                                                                    type="password" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>New Password</label>
                                                                <input name="new_password" id="new_password"
                                                                    placeholder="New Password" type="password" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Cofirm New Password</label>
                                                                <input name="confirm_password" id="confirm_password"
                                                                    placeholder="Confirm new password" type="password" />
                                                            </div>
                                                            <button class="submit submit-auto-width" type="submit">Change
                                                                Password</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        var newPasswordInput = document.getElementById('new_password');
        var confirmPasswordInput = document.getElementById('confirm_password');
        var errorDiv = document.getElementById('error_message');

        newPasswordInput.addEventListener('keyup', validatePasswords);
        confirmPasswordInput.addEventListener('keyup', validatePasswords);

        function validatePasswords() {
            if (confirmPasswordInput.value === '') {
                errorDiv.innerText = '';
                errorDiv.style.display = 'none';
            } else if (newPasswordInput.value !== confirmPasswordInput.value) {
                errorDiv.innerText = 'Mật khẩu xác nhận không khớp!';
                errorDiv.style.display = 'block';
            } else {
                errorDiv.innerText = '';
                errorDiv.style.display = 'none';
            }
        }
    </script>
@endsection
