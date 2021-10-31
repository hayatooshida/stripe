@extends('layouts.app')

@section('content')

@foreach($cart as $carts)

{{ $carts->name }}
{{ $carts->price }}円
{{ $carts->quantity }}個

<div><img src="/upload/{{ $carts->image }}" width="300"></div>
<form method="POST" action="/cart/{{ $carts->id }}">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger ml-1">カートから削除する</button>
</form>
@endforeach

@if($total_price > 0)
<h2>合計金額：{{ $total_price }}円</h2>
<button onClick="location.href='{{ route('cart.checkout') }}'" class="cart__purchase btn btn-success">
    購入する
</button>
@else
<h1 style="text-align:center">カートに商品は、入っていません</h1>
@endif
@endsection