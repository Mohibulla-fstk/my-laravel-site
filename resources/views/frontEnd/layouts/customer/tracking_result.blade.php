@extends('frontEnd.layouts.master')
@section('title')
<title>Track Oder</title>
@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <Span>Tracking Result</Span>
    </div>
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    @foreach($order as $key => $value)
                        <div class="form-content">
                            <p class="auth-title">Order Track Result</p>
                            <div class="track_info">
                                <ul>
                                    <li><span>Invoice ID:</span> {{$value->invoice_id}} </li>
                                    <li><span>Name:</span> {{$value->name}} </li>
                                    <li><span>Phone:</span> {{$value->phone}} </li>
                                    <li><span>Address:</span> {{$value->address}} </li>
                                    <li><span>Date:</span> {{$value->created_at}} </li>
                                    <li><span>Status:</span>
                                        {{App\Models\Orderstatus::where('id', $value->order_status)->first()->name}} </li>
                                </ul>
                            </div>
                            <table class="table table-bordered tracktable">
                                <thead>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </thead>
                                <tbody>
                                    @php 
                                        $orderdetails = App\Models\OrderDetails::where(['order_id' => $value->id])->get();
                                    @endphp
                                        @foreach($orderdetails as $key => $orderdetail)
                                        <tr>
                                            <td>{{$orderdetail->product_name}}</td>
                                            <td>{{$orderdetail->qty}}</td>
                                            <td style="text-align:right;">{{$orderdetail->sale_price * $orderdetail->qty}} TK</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfo    ot>
                                        <tr>
                                    <td colspan="2"></td>
                                    <td class="tfoot_bg"><span>Delivery Charge:</span> {{$value->shipping_charge}} Tk.</td>
                                        </tr>
                                        <tr>
                                    <td colspan="2"></td>
                                    <td class="tfoot_bg"><span>Total:</span> {{$value->amount}} Tk.</td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
    <script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush