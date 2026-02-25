@php
  $subtotal = Cart::instance('shopping')->subtotal();
  $subtotal = str_replace(',', '', $subtotal);
  $subtotal = str_replace('.00', '', $subtotal);
  view()->share('subtotal', $subtotal);
@endphp



<a class="carttoggle">
    <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg>
  <span>{{Cart::instance('shopping')->count()}}</span>
</a>




<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
<script>
  feather.replace()
</script>
<!-- cart js start -->
<script>
  // Increment


  // Remove
  $(".cart_remove").on("click", function () {
    var id = $(this).data("id");
    if (id) {
      $.ajax({
        type: "GET",
        data: { id: id },
        url: "{{route('cart.remove')}}",
        success: function (data) {
          if (data) {
            $(".cartlist").html(data);
            return cart_count() + mobile_cart() + cart_summary();
          }
        },
      });
    }
  });



  // Size change
  $(document).on('change', '.cart-size-selector', function () {
    var rowId = $(this).data('id');
    var product_size = $(this).val();
    $.ajax({
      type: "GET",
      url: "{{ route('cart.update') }}",
      data: { id: rowId, product_size: product_size },
      success: function (data) {
        $(".cartlist").html(data); // <-- এখানে পরিবর্তন
        cart_count();
      }
    });
  });

  // Color change
  $(document).on('change', '.cart-color-selector', function () {
    var rowId = $(this).data('id');
    var product_color = $(this).val();
    $.ajax({
      type: "GET",
      url: "{{ route('cart.update') }}",
      data: { id: rowId, product_color: product_color },
      success: function (data) {
        $(".cartlist").html(data); // <-- এখানে পরিবর্তন
        cart_count();
      }
    });
  });





</script>

<script>
  $(".carttoggle").on("click", function () {
    $("#page-overlay").show();
    $(".cartmenu").addClass("active");
  });

  $("#page-overlay").on("click", function () {
    $("#page-overlay").hide();
    $(".cartmenu").removeClass("active");

  });

  $(".crossmark").on("click", function () {
    $("#page-overlay").hide();
    $(".cartmenu").removeClass("active");
  });


</script>
<!-- cart js end -->