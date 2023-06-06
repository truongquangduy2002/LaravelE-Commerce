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
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
            <!--end breadcrumb-->


            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="card border-top border-0 border-4 border-info">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bxs-key me-1 font-22 text-info"></i>
                                    </div>
                                    <h5 class="mb-0 text-info">Change Password</h5>
                                </div>
                                <hr />

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

                                @if ($errors->any())
                                    <div style="color: red;">
                                        {{ $errors->first('error') }}
                                    </div>
                                @endif

                                <div id="error_message" style="color: red; display: none;"></div>

                                <form id="passwordForm" action="{{ route('admin.password.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="inputChoosePassword2" class="col-sm-3 col-form-label">Old
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="old_password" class="form-control"
                                                id="inputChoosePassword2" placeholder="Old Password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputConfirmPassword2" class="col-sm-3 col-form-label">New
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="new_password" class="form-control"
                                                placeholder="New Password" id="new_password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputConfirmPassword2" class="col-sm-3 col-form-label">Confirm
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="confirm_password" class="form-control"
                                                placeholder="Confirm New Password" id="confirm_password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5">Change Password</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->

    {{-- <script>
        var newPasswordInput = document.getElementById('new_password');
        var confirmPasswordInput = document.getElementById('confirm_password');
        var errorDiv = document.getElementById('error_message');
    
        newPasswordInput.addEventListener('keyup', validatePasswords);
    
        function validatePasswords() {
          if (confirmPasswordInput.value !== '' && newPasswordInput.value !== confirmPasswordInput.value) {
            errorDiv.innerText = 'Mật khẩu xác nhận không khớp!';
            errorDiv.style.display = 'block';
          } else {
            errorDiv.innerText = '';
            errorDiv.style.display = 'none';
          }
        }
      </script> --}}

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

    {{-- <script>
        var newPasswordInput = document.getElementById('new_password');
        var confirmPasswordInput = document.getElementById('confirm_password');
        var errorDiv = document.getElementById('error_message');

        newPasswordInput.addEventListener('keyup', validatePasswords);
        confirmPasswordInput.addEventListener('keyup', validatePasswords);

        function validatePasswords() {
            if (newPasswordInput.value !== confirmPasswordInput.value) {
                errorDiv.innerText = 'Mật khẩu xác nhận không khớp!';
                errorDiv.style.display = 'block';
            } else {
                errorDiv.innerText = '';
                errorDiv.style.display = 'none';
            }
        }
    </script> --}}

    {{-- <script>
        document.getElementById('confirm_password').addEventListener('keyup', function() {
            var errorDiv = document.getElementById('error_message');
            errorDiv.innerText = (document.getElementById('new_password').value !== this.value) ?
                'Mật khẩu xác nhận không khớp!' : '';
            errorDiv.style.display = (errorDiv.innerText !== '') ? 'block' : 'none';
            // setTimeout(function() {
            //     errorDiv.style.display = 'none';
            // }, 3000);
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('passwordForm');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var new_password = document.getElementById('new_password').value;
                var confirm_password = document.getElementById('confirm_password').value;

                if (new_password !== confirm_password) {
                    showErrorMessage('Mật khẩu xác nhận không khớp!');
                } else {
                    axios.post(form.action, new FormData(form))
                        .then(function(response) {
                            // Xử lý phản hồi thành công
                        })
                        .catch(function(error) {
                            if (error.response && error.response.data) {
                                showErrorMessage(error.response.data.error);
                            }
                        });
                }
            });

            function showErrorMessage(message) {
                var errorDiv = document.getElementById('error_message');
                errorDiv.innerText = message;
                errorDiv.style.color = 'red';
                errorDiv.style.display = 'block';
                setTimeout(function() {
                    errorDiv.style.display = 'none';
                }, 3000);
            }
        });
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection
