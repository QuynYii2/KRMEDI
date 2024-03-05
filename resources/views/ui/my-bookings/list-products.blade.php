@extends('layouts.admin')
@section('title')
    {{ __('home.List products') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List products') }}</h1>
    <div class="container-fluid">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.Product name') }}</th>
                <th scope="col">{{ __('home.Price') }}</th>
                <th scope="col">{{ __('home.Category') }}</th>
            </tr>
            </thead>
            <tbody>
            @if(count($products) > 0)
                @foreach($products as $product)
                    <tr>
                        <th scope="row"> {{ $loop->index + 1 }} </th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            @php
                                $category = \App\Models\online_medicine\CategoryProduct::find($product->category_id);
                            @endphp
                            {{ $category->name }}
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
