@extends('frontend::layouts.master')

@section('title')
    Confirm password
@stop

@section('content')
    <h1>Confirm password</h1>
    <hr>
    {!! Form::open([
        'route' => 'frontend.account.confirmPassword',
    ]) !!}

        <div class="form-group">
            {!! Form::label('password') !!}

            {!! Form::password('password', [
                'class' => 'form-control',
                'placeholder' => '******'
            ]) !!}
        </div>
        <div class="form-group">

            <button type="submit" class="btn btn-primary">
                Confirm
            </button>
        </div>

    {!! Form::close() !!}
@stop