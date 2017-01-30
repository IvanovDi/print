@extends('backend::layouts.master')

@section('title')
    Addon edit
@stop

@section('breadcrumb')
    <li><a href="{!! route('addons.index') !!}">Addons</a></li>
    <li class="active">Edit</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            {!! Form::open([
                'route' => ['addons.update', $addon->id],
                'method' => 'PUT',
            ]) !!}
                @include('backend::addons.blocks._form', [
                    'addon' => $addon,
                ])
            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body">
                            <label>Option</label>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#js_addOption">
                                            <h4 class="panel-title">
                                                Add +
                                            </h4>
                                        </a>
                                    </div>
                                    <div id="js_addOption" class="panel-collapse collapse @if($errors->has('option_add_name') || $errors->has('price')) in @endif">
                                        <div class="panel-body">
                                            {!! Form::open([
                                                'method' => 'post',
                                                'route' => ['addons.options.store', $addon->id],
                                            ]) !!}
                                                <div class="form-group @if($errors->has('option_add_name')) has-error @endif">
                                                    {!! Form::label('option_add_name', 'Name') !!}
                                                    {!! Form::text('option_add_name', null, [
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                    @if ($errors->has('option_add_name'))
                                                        <p class="alert-danger">{!! $errors->get('option_add_name')[0] !!}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group @if($errors->has('price')) has-error @endif">
                                                    {!! Form::label('price', 'Price') !!}
                                                    {!! Form::number('price', null, [
                                                        'class' => 'form-control',
                                                        'step' => '0.01',
                                                    ]) !!}
                                                    @if ($errors->has('price'))
                                                        <p class="alert-danger">{!! $errors->get('price')[0] !!}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>*</th>
                                    <th>*</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($options as $option)
                                        <tr>
                                            {!! Form::open([
                                                'method' => 'put',
                                                'route' => ['addons.options.update', $addon->id, $option->id],
                                            ]) !!}
                                                <td class="@if($errors->has('option_name[' . $option->id . ']')) has-error @endif">
                                                    {!! Form::text('option_name[' . $option->id . ']', $option->name, [
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                    @if ($errors->has('option_name[' . $option->id . ']'))
                                                        <p class="alert-danger">{!! $errors->get('option_name[' . $option->id . ']')[0] !!}</p>
                                                    @endif
                                                </td>
                                                <td class="@if($errors->has('option_price[' . $option->id . ']')) has-error @endif">
                                                    {!! Form::number('option_price[' . $option->id . ']', $option->price, [
                                                        'class' => 'form-control',
                                                        'step' => '0.01',
                                                    ]) !!}
                                                    @if ($errors->has('option_price[' . $option->id . ']'))
                                                        <p class="alert-danger">{!! $errors->get('option_price[' . $option->id . ']')[0] !!}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-danger" form="delete_{!! $option->id !!}">Delete</button>
                                                </td>
                                            {!! Form::close() !!}

                                            {!! Form::open([
                                                'id' => 'delete_' . $option->id,
                                                'method' => 'delete',
                                                'route' => ['addons.options.delete', $addon->id, $option->id],
                                            ]) !!}

                                            {!! Form::close() !!}
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $options->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop