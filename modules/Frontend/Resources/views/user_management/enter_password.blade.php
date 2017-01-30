@extends('frontend::layouts.master')

@section('title')
    Enter your password
@stop

@section('content')

    <h1>Enter your password</h1>
    <hr>
    {!! Form::open([
        'route' => 'frontend.accept_invitation.enterPasswordForInvitationUser',
    ]) !!}

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::hidden('token', $token) !!}
            {!! Form::label('password') !!}
            {!! Form::password('password', [
                'class' => 'form-control',
                'placeholder' => '******',
            ]) !!}
            @if ($errors->has('password'))
                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('password_confirmation') !!}
            {!! Form::password('password_confirmation', [
                'class' => 'form-control',
                'placeholder' => '******',
            ]) !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Enter
            </button>
        </div>
    {!! Form::close() !!}

@stop