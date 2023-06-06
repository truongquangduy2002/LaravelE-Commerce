@php
    $banner = App\Models\Banner::orderBy('banner_title', 'ASC')
        ->limit(3)
        ->get();
@endphp
<section class="banners mb-25">
    <div class="container">
        <div class="row">
            @foreach ($banner as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                        {{-- <img src="{{ asset('frontend/assets/imgs/banner/banner-1.png') }}" alt="" /> --}}
                        <img src="{{ asset($item->banner_image) }}" alt="" />
                        <div class="banner-text">
                            <h4>
                                {{ $item->banner_title }}
                            </h4>
                            <a href="{{ $item->banner_url }}" class="btn btn-xs">Shop Now <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <img src="{{ asset('frontend/assets/imgs/banner/banner-1.png') }}" alt="" />
                    <div class="banner-text">
                        <h4>
                            Everyday Fresh & <br />Clean with Our<br />
                            Products
                        </h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
