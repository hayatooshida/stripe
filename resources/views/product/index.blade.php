@extends('layouts.app')
@section('content')
@foreach($product as $products)
{{ $products->name }}
{{ $products->price }}
{{ $products->description }}
<div><img src="/upload/{{ $products->image }}" width="300"></div>
@endforeach
@endsection