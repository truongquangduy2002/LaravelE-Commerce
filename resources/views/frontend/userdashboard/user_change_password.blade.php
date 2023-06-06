@extends('dashboard')
@section('dashboard')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Change Password
            </div>
        </div>
    </div>
    <div class="page-content pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="row">
                        <!-- // Start Col md 3 menu -->
                        @include('frontend.body.dashboard_sidebar_menu')
                        <!-- // End Col md 3 menu -->
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">
                                <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                    aria-labelledby="dashboard-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Password</h5>
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
                                                        action="{{ route('user.update.password') }}" method="POST"
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
