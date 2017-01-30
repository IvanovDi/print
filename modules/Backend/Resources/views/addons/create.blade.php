@extends('backend::layouts.master')

@section('title')
    Addon create
@stop

@section('breadcrumb')
    <li><a href="{!! route('addons.index') !!}">Addons</a></li>
    <li class="active">Create</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open([
                'route' => 'addons.store',
                'method' => 'post',
            ]) !!}
                @include('backend::addons.blocks._form', [
                    'addon' => new \Modules\Backend\Entities\Addon(),
                ])
            {!! Form::close() !!}
        </div>
    </div>
@stop