@if ($notification->data['resend'])
    Company <b>{!! $company->company_real_name !!}</b> resend request <br>
@else
    Company <b>{!! $company->company_real_name !!}</b> send request <br>
@endif
{!! Form::open([
   'route' => 'frontend.accept_invitation.acceptInvitation',
   'style' => 'display: inline-block',
   'method' => 'get',
]) !!}

    {!! Form::hidden('notification_id', $notification->id) !!}
    {!! Form::hidden('token', $notification->data['token']) !!}
    <button type="submit" class="btn btn-success">Accept</button>

{!! Form::close() !!}

{!! Form::open([
    'route' => 'frontend.decline_invitation.declineInvitation',
    'style' => 'display: inline-block',
]) !!}

    {!! Form::hidden('notification_id', $notification->id) !!}
    {!! Form::hidden('token', $notification->data['token']) !!}
    <button type="submit" class="btn btn-danger">Decline</button>

{!! Form::close() !!}