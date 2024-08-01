@extends('layouts.mail')

@section('content')
    <h1>Order Status</h1>
    <p>Your order has been updated to: {{ $order->status }}</p>
@endsection