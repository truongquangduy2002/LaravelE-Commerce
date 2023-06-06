@extends('admin.admin_dashboard')
@section('admin')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Product</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">All Product</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <div class="col">
                            <a href="{{ route('add.product') }}"><button type="button"
                                    class="btn btn-primary px-5 radius-30">Add Product</button></a>
                        </div>
                    </div>
                </div>

            </div>
            <!--end breadcrumb-->
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image </th>
                                    <th>Product Name </th>
                                    <th>Price </th>
                                    <th>QTY </th>
                                    <th>Discount </th>
                                    <th>Status </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td> <img src="{{ asset($item->product_thambnail) }}"
                                                style="width: 70px; height:40px;">
                                        </td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->selling_price }}</td>
                                        <td>{{ $item->product_qty }}</td>
                                        <td>
                                            @if ($item->discount_price == null)
                                                <span class="badge rounded-pill bg-info">No Discount</span>
                                            @else
                                                @php
                                                    $amount = $item->selling_price - $item->discount_price;
                                                    $discount = ($amount / $item->selling_price) * 100;
                                                @endphp
                                                <span class="badge rounded-pill bg-danger"> {{ round($discount) }}%</span>
                                            @endif
                                            {{-- {{ $item->discount_price }} --}}
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">InActive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info" title="Edit Data"> <i
                                                    class="fa-solid fa-pencil"></i> </a>
                                            <a href="" class="btn btn-danger" id="delete" title="Delete Data"><i
                                                    class="fa fa-trash"></i></a>
                                            <a href="" class="btn btn-warning" title="Details Page"><i
                                                    class="fa-solid fa-eye"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Image </th>
                                    <th>Product Name </th>
                                    <th>Price </th>
                                    <th>QTY </th>
                                    <th>Discount </th>
                                    <th>Status </th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end page wrapper -->
@endsection
