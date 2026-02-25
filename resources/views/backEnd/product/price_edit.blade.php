@extends('backEnd.layouts.master')
@section('title','Product Price Manage')
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('products.create')}}" class="btn btn-danger rounded-pill"><i class="fe-shopping-cart"></i> Add Product</a>
                </div>
                <h4 class="page-title">Product Price Manage</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{route('products.price_update')}}" method="POST">
                @csrf
            <div class="card-body">
    <div class="table-responsive">
        <table class="table nowrap w-100">
            <thead>
                <tr>
                    <th style="width:5%">SL</th>
                    <th style="width:50%">Name</th>
                    <th style="width:10%">Old Price</th>
                    <th style="width:10%">New Price</th>
                    <th style="width:10%">Stock</th>
                    <th style="width:25%">Stock Status</th> <!-- Added status column -->
                </tr>
            </thead>               
            <tbody>
                @foreach($products as $key=>$value)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <input type="hidden" value="{{$value->id}}" name="ids[]">
                    <td>{{$value->name}}</td>
                    <td><input value="{{$value->old_price}}" name="old_price[]"></td>
                    <td><input value="{{$value->new_price}}" name="new_price[]"></td>
                    <td>
                        <input type="text" value="{{$value->stock}}" name="stock[]" class="stock-input" data-row="{{$key}}">
                    </td>
                    <td>
                        <select name="stockstatus[]" class="stockstatus-select form-control" data-row="{{$key}}">
                            <option value="">Select</option>
                            <option value="IN STOCK" {{$value->stock > 0 ? 'selected' : ''}}>IN STOCK</option>
                            <option value="STOCK OUT" {{$value->stock <= 0 ? 'selected' : ''}}>STOCK OUT</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"></td>
                    <td>
                        <button class="btn btn-success">Update Price</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
            </div> <!-- end card body-->
            </form>
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    function updateStockStatus(row) {
        let stockVal = parseInt($(`.stock-input[data-row="${row}"]`).val()) || 0;
        let statusSelect = $(`.stockstatus-select[data-row="${row}"]`);
        if(stockVal > 0){
            statusSelect.val('IN STOCK').trigger('change');
        } else {
            statusSelect.val('STOCK OUT').trigger('change');
        }
    }

    // Initial check for all rows
    $('.stock-input').each(function() {
        let row = $(this).data('row');
        updateStockStatus(row);
    });

    // Update on input change
    $('.stock-input').on('input', function() {
        let row = $(this).data('row');
        updateStockStatus(row);
    });
});
</script>

<script>
$(document).ready(function(){
    $(".checkall").on('change',function(){
      $(".checkbox").prop('checked',$(this).is(":checked"));
    });
    
    $(document).on('click', '.hotdeal_update', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('url',url);
        var product = $('input.checkbox:checked').map(function(){
          return $(this).val();
        });
        var product_ids=product.get();
        if(product_ids.length ==0){
            toastr.error('Please Select A Product First !');
            return ;
        }
        $.ajax({
           type:'GET',
           url:url,
           data:{product_ids},
           success:function(res){
               if(res.status=='success'){
                toastr.success(res.message);
                window.location.reload();
            }else{
                toastr.error('Failed something wrong');
            }
           }
        });
    });
    $(document).on('click', '.update_status', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var product = $('input.checkbox:checked').map(function(){
          return $(this).val();
        });
        var product_ids=product.get();
        if(product_ids.length ==0){
            toastr.error('Please Select A Product First !');
            return ;
        }
        $.ajax({
           type:'GET',
           url:url,
           data:{product_ids},
           success:function(res){
               if(res.status=='success'){
                toastr.success(res.message);
                window.location.reload();
            }else{
                toastr.error('Failed something wrong');
            }
           }
        });
    });
    $(document).on('click', '.update_status', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var product = $('input.checkbox:checked').map(function(){
          return $(this).val();
        });
        var product_ids=product.get();
        if(product_ids.length ==0){
            toastr.error('Please Select A Product First !');
            return ;
        }
        $.ajax({
           type:'GET',
           url:url,
           data:{product_ids},
           success:function(res){
               if(res.status=='success'){
                toastr.success(res.message);
                window.location.reload();
            }else{
                toastr.error('Failed something wrong');
            }
           }
        });
    });
    
    
})
</script>
@endsection