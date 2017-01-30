@extends('frontend::layouts.master')

@section('title')
    Edit account
@stop

@section('breadcrumb')
    <li class="active">Edit account</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            {!! Form::open([
                'method' => 'post',
                'route' => 'frontend.account.changeEmail',
                'class' => 'form-horizontal',
            ]) !!}
                <p>Your current email address <b>{!! $currentUser->email !!}</b></p>
                <div class="form-group{{ $errors->has('new_email') ? ' has-error' : '' }}">
                    {!! Form::label('new_email', 'Change email address') !!}

                    {!! Form::email('new_email', '', [
                        'class' => 'form-control',
                        'placeholder' => 'new email',
                    ]) !!}

                    @if ($errors->has('new_email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            {!! Form::open([
                'route' => 'frontend.account.sendEmailChangePassword',
            ]) !!}

                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                    {!! Form::label('old_password') !!}

                    {!! Form::password('old_password', [
                        'class' => 'form-control',
                        'placeholder' => '******',
                    ]) !!}
                    @if ($errors->has('old_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {!! Form::label('password_confirmation') !!}

                    {!! Form::password('password_confirmation', [
                        'class' => 'form-control',
                        'placeholder' => '******',
                    ]) !!}
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Change
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop