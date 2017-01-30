@extends('frontend::layouts.master')

@section('title')
    User management
@stop

@section('breadcrumb')
    <li class="active">User management</li>
@stop

@section('content')

    <h1>User Management</h1>
    <hr>
    <div class="row">
        {!! Form::open([
            'class' => 'form-inline',
            'route' => 'frontend.user_management.sendInvitation',
        ]) !!}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::email('email', '', [
                    'class' => 'form-control',
                    'placeholder' => 'email'
                ]) !!}
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Send invitation</button>
            </div>

        {!! Form::close() !!}
    </div>

    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($invitations as $invitation)
                <tr>
                    <td>{!! $invitation->user->email ?? $invitation->email !!}</td>
                    <td>
                        @if ($invitation->trashed())
                            @if ($invitation->is_active)
                                Deactivated
                            @else
                                Declined
                            @endif
                        @elseif ($invitation->is_active)
                            Active
                        @else
                            Inactive
                        @endif
                    </td>
                    <td>
                        @if (!$invitation->trashed())
                            {!! Form::open([
                                'method' => 'delete',
                                'route' => ['frontend.user_management.deactivateUser', $invitation->id]
                            ]) !!}

                                <button type="submit" class="btn btn-danger">Delete from company</button>

                            {!! Form::close() !!}
                        @else
                            @if ($invitation->is_active)
                                {!! Form::open([
                                    'route' => ['frontend.user_management.activateUser', $invitation->id]
                                ]) !!}

                                <button type="submit" class="btn btn-success">Activate</button>

                                {!! Form::close() !!}
                            @endif
                        @endif
                    </td>
                    <td>
                        @if (!$invitation->trashed() && !$invitation->is_active)
                            {!! Form::open([
                                'route' => ['frontend.user_management.resendInvitation', $invitation->id]
                            ]) !!}

                                <button type="submit" class="btn btn-primary">Resend invitation</button>

                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop