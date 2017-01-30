@extends('backend::layouts.master')

@section('title')
    Addons
@stop

@section('breadcrumb')
    <li class="active">Addons</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                Addons
                <a href="{!! route('addons.create') !!}" class="btn btn-default pull-right">Create</a>
            </h1>
        </div>
    </div>
    <hr>
    {{ $addons->links() }}
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>*</th>
        </tr>
        </thead>
        <tbody>
            @foreach($addons as $addon)
                <tr>
                    <td><a href="{!! route('addons.edit', $addon->id) !!}">{!! $addon->name !!}</a></td>
                    <td>{!! $addon->type_views !!}</td>
                    <td>
                        {!! Form::open([
                            'route' => ['addons.destroy', $addon->id],
                            'method' => 'delete',
                        ]) !!}
                            <button class="btn btn-danger" type="submit">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop