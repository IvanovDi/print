@extends('frontend::layouts.master')

@section('title')
    Update profile
@stop

@section('breadcrumb')
    <li class="active">Update profile</li>
@stop

@section('content')
    <?php
        $label = 2;
        $input = 12 - $label;
    ?>
    <h1>Update @if ($currentUser->is_company) Company @else Profile @endif</h1>
    <hr>
    @if (!$currentUser->is_company)
        Companies
        @foreach($companies as $company)
            <a href="" class="btn btn-primary">{!! $company->company_real_name !!}</a>
        @endforeach
        <hr>
    @endif
    {!! Form::open([
        'class' => 'form-horizontal',
        'method' => 'post',
        'route' => 'frontend.profile.update'
    ]) !!}

        <div class="form-group">
            {!! Form::label('company_name', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('company_name', $currentUser['company_name'], [
                    'class' => 'form-control',
                    'placeholder' => 'company name'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('first_name', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('first_name', $currentUser['first_name'], [
                    'class' => 'form-control',
                    'placeholder' => 'first name'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('last_name', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('last_name', $currentUser['last_name'], [
                    'class' => 'form-control',
                    'placeholder' => 'last name'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('address', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('address', $currentUser['address'], [
                    'class' => 'form-control',
                    'placeholder' => 'address'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('phone', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('phone', $currentUser['phone'], [
                    'class' => 'form-control',
                    'placeholder' => 'phone'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('fax', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('fax', $currentUser['fax'], [
                    'class' => 'form-control',
                    'placeholder' => 'fax'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('web', '', [
                'class' => 'col-sm-' . $label . ' control-label',
            ]) !!}
            <div class="col-sm-{!! $input !!}">
                {!! Form::text('web', $currentUser['web'], [
                    'class' => 'form-control',
                    'placeholder' => 'web'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-{!! $label !!} col-sm-{!! $input !!}">
                <button type="submit" class="btn btn-default">Update</button>
            </div>
        </div>

    {!! Form::close() !!}
@stop