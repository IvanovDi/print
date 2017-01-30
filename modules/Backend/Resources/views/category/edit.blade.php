@extends('backend::layouts.master')

@section('title')
    Category create
@stop

@section('breadcrumb')
    <li class="active"><a href="{!! route('category.index') !!}">Categories</a></li>
    <li class="active">Edit</li>
@stop

@section('content')
    <div class="row">
        {!! Form::open([
            'route' => ['category.update', $category->id],
            'files' => true,
            'class' => 'col-md-12',
            'method' => 'PUT',
            'id' => 'form',
        ]) !!}
            @include('backend::category.blocks._form', [
                'category' => $category,
                'categories' => $categories,
            ])
        {!! Form::close() !!}
    </div>
    @include('backend::category.blocks._addProductsForm', [
        'category' => $category,
    ])
@stop