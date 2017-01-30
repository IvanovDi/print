@extends('backend::layouts.master')

@section('title')
    Users
@stop

@section('breadcrumb')
    <li class="active">Users</li>
@stop

@section('content')

    <h1>Users</h1>
    <hr>
    <div class="btn-group" role="group" aria-label="...">
        <a type="button" href="{!! route('backend.user.index', ['type' => 'all']) !!}" class="btn btn-default">All</a>
        <a type="button" href="{!! route('backend.user.index', ['type' => 'individual']) !!}" class="btn btn-default">Individual</a>
        <a type="button" href="{!! route('backend.user.index', ['type' => 'corporate']) !!}" class="btn btn-default">Corporate</a>
    </div>
    <hr>

    <table class="table">
        <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Type</th>
            <th>Companies</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td><a href="{!! route('backend.user.show', $user->id) !!}">{!! $user->email !!}</a></td>
                <td>{!! $user->company_name !!}</td>
                <td>{!! $user->is_company ? 'Corporate' : 'Individual' !!}</td>
                <td>
                    @if (!$user->is_company)
                        @foreach($user->companies as $companies)
                            {!! $companies->company_name ? $companies->company_name : $companies->email !!}
                            @if (!$loop->last)
                                /
                            @endif
                        @endforeach
                    @endif
                </td>
                <td>
                    {!! Form::open([
                        'route' => ['backend.user.loginAsUser', $user->id],
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