@extends('backend::layouts.master')

@section('title')
    Product edit
@stop

@section('breadcrumb')
    <li><a href="{!! route('products.index') !!}">Products</a></li>
    <li class="active">Edit</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            {!! Form::open([
                'route' => ['products.update', $product->id],
                'method' => 'PUT',
                'files' => true,
            ]) !!}
                @include('backend::products.blocks._form', [
                    'product' => $product,
                ])
            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            @include('backend::products.blocks.edit_prices')
        </div>
    </div>
    <div class="panel panel-default">
        <div class="row">
            <div class="panel-body">
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Addons product</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->addons as $addon)
                            <tr>
                                <td>
                                    Addon:
                                    {!! $addon->name !!}
                                </td>
                                <td>
                                    {!! Form::open([
                                        'route' => ['product.addon.detachAddons', $addon->id],
                                        'method' => 'POST',
                                        'style' => 'display:inline-block',
                                    ]) !!}
                                        {!! Form::hidden('product_id', $product->id) !!}
                                        <button type="submit" class="btn-danger btn">delete</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Other addons</td>
                            <td>*</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($addons as $addon)
                                @if (!array_key_exists($addon->id, $addonsFromProduct))
                                    <tr>
                                        <td>
                                            Product:
                                            {!! $addon->name !!}
                                        </td>
                                        <td>
                                            {!! Form::open([
                                                'route' => ['product.addon.attachAddons', $addon->id],
                                                'method' => 'POST',
                                                'style' => 'display:inline-block',
                                            ]) !!}
                                                {!! Form::hidden('product_id', $product->id) !!}
                                                <button type="submit" class="btn-primary btn">add</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop