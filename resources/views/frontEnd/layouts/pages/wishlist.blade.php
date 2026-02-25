@extends('frontEnd.layouts.master')

@section('title','Wishlist')

@section('content')
<div class="blankspace"></div>

<div class="gradient-bg">
    <span>My Wishlist</span>
</div>

<div class="container py-4">
<h3>My Wishlist</h3> 
    @if(count($wishlist) > 0)
        <div class="row">
            @foreach($wishlist as $item)
                <div class="col-md-3 wishlist-item" data-id="{{ $item['id'] }}">
                    <div class="product_item wist_item">
                        <div class="product_item_inner">

                            <div class="pro_img">
                                {{-- Main Image --}}
                                <a href="{{ route('product', $item['slug']) }}">
                                    <img 
                                        src="{{ asset($item['image']) }}" 
                                        alt="{{ $item['name'] }}" 
                                        class="main-img"
                                    >
                                </a>

                                {{-- Hover Image --}}
                                @if(!empty($item['second_image']))
                                <a href="{{ route('product', $item['slug']) }}">
                                    <img 
                                        src="{{ asset($item['second_image']) }}" 
                                        alt="{{ $item['name'] }} hover" 
                                        class="hover-img"
                                    >
                                </a>
                                @endif

                                {{-- Quick View --}}
                                <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-{{ $item['id'] }}">
                                    <span>Quick View</span>
                                    {{-- Optional: show available sizes --}}
                                    <div class="sizeShowproduct">
                                        @if(!empty($item['prosizes']) && count($item['prosizes']) > 0)
                                            @foreach($item['prosizes'] as $size)
                                                <span>{{ $size['sizeName'] ?? '-' }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="pro_des text-left">
                                <div class="pro_name">
                                    <a href="{{ route('product', $item['slug']) }}">
                                        {{ Str::limit($item['name'], 40) }}
                                    </a>
                                </div>
                                    <div class="pro_stockstatus {{ ($item['stock'] ?? 0) >= 1 ? 'text-success' : 'text-danger' }}">
                                    {{ ($item['stock'] ?? 0) >= 1 ? 'In Stock' : 'Stock Out' }}
                                    
                                </div>

                               
                                 @if ($item['stock'] < 1)
                                    <div class="pro_price">
                                        <p>
                                            <del>0.00৳</del>
                                            0.00৳
                                        </p>
                                    </div>
                                    @else
                                    <div class="pro_price">
                                        <p>
                                            @if ($item['old_price'])
                                                <del>{{ $item['old_price'] }}.00৳</del>
                                            @endif
                                            {{ $item['new_price'] }}.00৳
                                        </p>
                                    </div>
                                    @endif

                                <button 
                                    class="wishlist-toggle-remove btn btn-sm btn-danger mt-2"
                                    data-product-id="{{ $item['id'] }}"
                                >
                                    Remove 
                                </button>
                                
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            
            <div style="display: flex;flex-direction:column">
                <span style="font-size: 30px;font-weight:500">Wishlist is empty !</span>
            <span>You don't have any products in the wishlist yet. You will find a lot of interesting products on our "Shop" page.</span>
            <div style="margin-top: 20px">
                <a href="{{ route('home') }}">
                <span class="span-class4">Return to shop <i
                                    class="fa-solid fa-arrow-right"></i></span></a>
                </div>
            </div>
        </div>
    @endif

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('click', '.wishlist-toggle-remove', function(e){
    e.preventDefault();

    let btn = $(this);
    let productId = btn.data('product-id');

    $.ajax({
        url: "{{ route('wishlist.toggle') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId
        },
        success: function(res){

            if(res.status === 'removed'){
                // Instant remove from DOM using data-id
                $('.wishlist-item[data-id="'+productId+'"]').fadeOut(300, function(){
                    $(this).remove();

                    // Empty wishlist message
                    if($('.wishlist-item').length === 0){
                        $('.container.py-4').html(`<div class="text-center py-5">
            
            <div style="display: flex;flex-direction:column">
                <span style="font-size: 30px;font-weight:500">Wishlist is empty !</span>
            <span>You don't have any products in the wishlist yet. You will find a lot of interesting products on our "Shop" page.</span>
            <div style="margin-top: 20px">
                <a href="{{ route('home') }}">
                <span class="span-class4">Return to shop <i
                                    class="fa-solid fa-arrow-right"></i></span></a>
                </div>
            </div>
        </div>`);
                    }
                });
            }

            // Update header wishlist count live
            if($('.wishlist-count-top').length){
                $('.wishlist-count-top').text(res.count);
            }

        },
        error: function(err){
            console.log(err);
            alert('Failed to remove product from wishlist!');
        }
    });
});
</script>
@endsection
