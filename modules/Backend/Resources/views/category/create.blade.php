@extends('backend::layouts.master')

@section('title')
    Category create
@stop

@section('breadcrumb')
    <li class="active"><a href="{!! route('category.index') !!}">Categories</a></li>
    <li class="active">Create</li>
@stop

@section('content')
    <div class="row">
        {!! Form::open([
            'route' => 'category.store',
            'files' => true,
            'class' => 'col-md-12',
            'method' => 'POST',
        ]) !!}
            @include('backend::category.blocks._form', [
                'category' => new \App\Entities\Category(),
            ])
        {!! Form::close() !!}

    </div>
@stop