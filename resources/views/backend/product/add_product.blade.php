@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Product</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
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

            <div class="card">
                <div class="card-body p-4">
                    <form id="myForm" action="{{ route('store.product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="border border-3 p-4 rounded">

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Product Name</label>
                                            <input type="text" name="product_name" value="{{ old('product_name') }}"
                                                class="form-control" id="product_name" placeholder="Enter product title">
                                        </div>
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Product Tags</label>
                                            <input type="text" name="product_tags"
                                                value="{{ old('product_tags') ? old('product_tags') : 'new product, top product' }}"
                                                class="form-control visually-hidden" data-role="tagsinput">
                                        </div>
                                        @error('product_tags')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Product Size</label>
                                            <input type="text" name="product_size"
                                                value="{{ old('product_size') ? old('product_size') : 'Small,Midium,Large' }}"
                                                class="form-control visually-hidden" data-role="tagsinput">
                                        </div>
                                        @error('product_size')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Product Color</label>
                                            <input type="text" name="product_color"
                                                value="{{ old('product_color') ? old('product_color') : 'Red,Blue,Black' }}"
                                                class="form-control visually-hidden" data-role="tagsinput">
                                        </div>
                                        @error('product_color')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Short Description</label>
                                            <textarea class="form-control" name="short_descp" id="inputProductDescription" rows="3">{{ old('short_descp') }}</textarea>
                                        </div>
                                        @error('short_descp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Long Description</label>
                                            <textarea id="mytextarea" name="long_descp">{{ old('long_descp') }}</textarea>
                                        </div>
                                        @error('long_descp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        {{-- <div class="form-group mb-3">
                                            <label for="inputProductDescription" class="form-label">Main Thumbnail</label>
                                            <input name="product_thambnail" class="form-group" type="file" id="formFile"
                                                onchange="mainThumUrl(this)">

                                            <img src="" id="mainThmb" alt="">
                                        </div> --}}
                                        <div class="form-group mb-3">
                                            <label for="inputProductTitle" class="form-label">Main Thumbnail</label>
                                            <input name="product_thambnail" class="form-control" type="file"
                                                id="formFile" onchange="mainThumUrl(this)">

                                            <img src="" id="mainThmb" alt="">

                                        </div>
                                        @error('product_thambnail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group mb-3">
                                            <label for="inputProductTitle" class="form-label">Multiple Image</label>
                                            <input class="form-control" name="multi_img[]" type="file" id="multiImg"
                                                multiple>
                                            {{-- <input type="text" id="image_count" readonly> --}}

                                            <div class="row" id="preview_img"></div>

                                        </div>
                                        {{-- <span id="error_message" style="color: red; display: none;">Chỉ được chọn tối đa
                                            là 10 ảnh.</span> --}}
                                        @error('multi_img')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="inputPrice" class="form-label">Product Price</label>
                                                <input type="number" id="selling_price" name="selling_price"
                                                    value="{{ old('selling_price') }}" class="form-control"
                                                    placeholder="00.00">
                                            </div>
                                            @error('selling_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div class="col-md-12">
                                                <label for="inputCostPerPrice" class="form-label">Discount Price</label>
                                                <input type="number" id="discount_price" name="discount_price"
                                                    value="{{ old('discount_price') }}" class="form-control"
                                                    placeholder="00.00">
                                            </div>
                                            @error('discount_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <span id="error_message" style="color: red; display: none;">Giá ưu đãi không
                                                thể lớn hơn giá của sản phẩm!</span>
                                            <div class="col-md-6">
                                                <label for="inputCompareatprice" class="form-label">Product Code</label>
                                                <input type="text" name="product_code"
                                                    value="{{ old('product_code') }}" class="form-control"
                                                    id="product_code" placeholder="00.00" readonl>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputCompareatprice" class="form-label">Product
                                                    Quantity</label>
                                                <input type="text" name="product_qty"
                                                    value="{{ old('product_qty') }}" class="form-control"
                                                    id="inputCompareatprice" placeholder="00.00">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputProductType" class="form-label">Product Brand</label>
                                                <select name="brand_id" class="form-select" id="inputProductType">
                                                    <option>Option select this menu</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="inputVendor" class="form-label">Product Category</label>
                                                <select name="category_id" id="category_id" class="form-select"
                                                    id="inputVendor">
                                                    <option>Option select this menu</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-12">
                                                <label for="inputCollection" class="form-label">Product
                                                    SubCategory</label>
                                                <select name="subcategory_id" id="subcategory_id" class="form-select"
                                                    id="inputCollection">
                                                    <option>Option select this menu</option>

                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputCollection" class="form-label">Product Vendor</label>
                                                <select name="vendor_id" class="form-select" id="inputCollection">
                                                    <option>Option select this menu</option>
                                                    @foreach ($activeVendor as $vendor)
                                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">

                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="hot_deals"
                                                                type="checkbox" value="1" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault"> Hot
                                                                Deals</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="featured"
                                                                type="checkbox" value="1" id="flexCheckDefault">
                                                            <label class="form-check-label"
                                                                for="flexCheckDefault">Featured</label>
                                                        </div>
                                                    </div>




                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="special_offer"
                                                                type="checkbox" value="1" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">Special
                                                                Offer</label>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="special_deals"
                                                                type="checkbox" value="1" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">Special
                                                                Deals</label>
                                                        </div>
                                                    </div>

                                                </div> <!-- // end row  -->

                                            </div>

                                            <hr>


                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <input type="submit" class="btn btn-primary px-4"
                                                        value="Save Changes" />

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    product_name: {
                        required: true,
                    },
                    short_descp: {
                        required: true,
                    },
                    product_thambnail: {
                        required: true,
                    },
                    multi_img: {
                        required: true,
                    },
                    selling_price: {
                        required: true,
                    },
                    product_code: {
                        required: true,
                    },
                    product_qty: {
                        required: true,
                    },
                    brand_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    subcategory_id: {
                        required: true,
                    },
                },
                messages: {
                    product_name: {
                        required: 'Please Enter Product Name',
                    },
                    short_descp: {
                        required: 'Please Enter Short Description',
                    },
                    product_thambnail: {
                        required: 'Please Select Product Thambnail Image',
                    },
                    multi_img: {
                        required: 'Please Select Product Multi Image',
                    },
                    selling_price: {
                        required: 'Please Enter Selling Price',
                    },
                    product_code: {
                        required: 'Please Enter Product Code',
                    },
                    product_qty: {
                        required: 'Please Enter Product Quantity',
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
        function mainThamUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThmb').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#multiImg').on('change', function() { //on file input change
                if (window.File && window.FileReader && window.FileList && window
                    .Blob) { //check File API supported browser
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file) { //loop though each file
                        if (/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file
                                .type)) { //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file) { //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src',
                                        e.target.result).width(100).height(
                                        80); //create image element
                                    var deleteButton = $('<button/>').addClass(
                                        'delete-button').text('Delete').click(
                                        function() {
                                            $(this).parent()
                                                .remove(); //remove image on delete button click
                                        });
                                    var imageContainer = $('<div/>').addClass(
                                        'image-container').append(img,
                                        deleteButton
                                    ); //create container for image and delete button
                                    $('#preview_img').append(
                                        imageContainer
                                    ); //append image container to output element
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });
                } else {
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>

    {{-- Phần Ajax để hiện phần SubCategory Name khi lấy từ id của Category --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function() {
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ url('/subcategory/ajax') }}/" + category_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="subcategory_id"]').html('');
                            var d = $('select[name="subcategory_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="subcategory_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .subcategory_name + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
        });
    </script>

    {{-- Phần thông báo lỗi nếu mà Discount Price mà có giá lớn hơn Selling Pricce --}}
    <script>
        // document.getElementById("discount_price").addEventListener("keyup", function() {
        //     var sellingPrice = parseFloat(document.getElementById("selling_price").value);
        //     var discountPrice = parseFloat(this.value);

        //     if (discountPrice > sellingPrice) {
        //         document.getElementById("error_message").style.display = "inline";
        //     } else {
        //         document.getElementById("error_message").style.display = "none";
        //     }
        // });

        $(document).ready(function() {
            $('#discount_price').on('keyup', function() {
                var sellingPrice = parseFloat($('#selling_price').val());
                var discountPrice = parseFloat($(this).val());

                if (discountPrice > sellingPrice) {
                    $('#error_message').css('display', 'inline');
                } else {
                    $('#error_message').css('display', 'none');
                }
            });
        });
    </script>

    {{-- Phần ảnh không có giới hạn ở Multi Image --}}
    {{-- <script>
        document.getElementById("multiImg").addEventListener("change", function() {
            var selectedFiles = this.files;

            // Không giới hạn số lượng hình ảnh
            // var maxImagesAllowed = Number.MAX_SAFE_INTEGER;
            var maxImagesAllowed = 10;

            if (selectedFiles.length > maxImagesAllowed) {
                document.getElementById("error_message").style.display = "inline";
            } else {
                document.getElementById("error_message").style.display = "none";
            }
        });
    </script> --}}

    {{-- Random số ở Product Code --}}
    <script>
        document.getElementById("product_name").addEventListener("input", function() {
            var productName = this.value;
            var productCode = generateProductCode();
            document.getElementById("product_code").value = productCode;
        });

        function generateProductCode() {
            var min = 100000;
            var max = 999999;
            var productCode = Math.floor(Math.random() * (max - min + 1) + min);
            return productCode;
        }
    </script>
@endsection
