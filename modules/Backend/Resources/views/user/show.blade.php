@extends('backend::layouts.master')

@section('title')
    Users
@stop

@section('breadcrumb')
    <li><a href="{!! route('backend.user.index') !!}">Users</a></li>
    <li class="active">{!! $user->company_real_name !!}</li>
@stop

@section('content')

    <h1>{!! $user->is_company ? 'Company' : 'User' !!} {!! $user->company_real_name !!}</h1>
    <hr>
    <table class="table">
        <caption>Info</caption>
        <thead>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>Company name</td>
                <td>{!! $user->company_name !!}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{!! $user->email !!}</td>
            </tr>
            <tr>
                <td>First name</td>
                <td>{!! $user->first_name !!}</td>
            </tr>
            <tr>
                <td>Last name</td>
                <td>{!! $user->last_name !!}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{!! $user->address !!}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{!! $user->phone !!}</td>
            </tr>
            <tr>
                <td>Fax</td>
                <td>{!! $user->fax !!}</td>
            </tr>
            <tr>
                <td>Web</td>
                <td>{!! $user->web !!}</td>
            </tr>
        </tbody>
    </table>

        <table class="table">
            <caption>@if ($user->is_company) Employees @else Companies @endif</caption>
            <thead>
            <tr>
                <th>Email</th>
                <th>Company Name</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Fax</th>
                <th>Web</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                $relation = $user->is_company ? $user->employees : $user->companies;
            ?>
            @foreach($relation as $relatedUser)
                <tr>
                    <td><a href="{!! route('backend.user.show', $relatedUser->id) !!}">{!! $relatedUser->email !!}</a></td>
                    <td>{!! $relatedUser->company_name !!}</td>
                    <td>{!! $relatedUser->first_name !!}</td>
                    <td>{!! $relatedUser->last_name !!}</td>
                    <td>{!! $relatedUser->address !!}</td>
                    <td>{!! $relatedUser->phone !!}</td>
                    <td>{!! $relatedUser->fax !!}</td>
                    <td>{!! $relatedUser->web !!}</td>
                    <td>
                        {!! Form::open([
                            'route' => ['backend.user.loginAsUser', $relatedUser->id],
                            'target' => '_blank',
                        ]) !!}

                        <button type="submit" class="btn btn-default">Login</button>

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@stop