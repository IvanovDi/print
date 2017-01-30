@extends('backend::layouts.master')

@section('title')
    Product create
@stop

@section('breadcrumb')
    <li><a href="{!! route('products.index') !!}">Products</a></li>
    <li class="active">Create</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            {!! Form::open([
                'route' => 'products.store',
                'method' => 'post',
                'files' => true,
            ]) !!}
                @include('backend::products.blocks._form', [
                    'product' => new \App\Entities\Product(),
                ])
            {!! Form::close() !!}
        </div>
    </div>
@stop