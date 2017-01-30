@if ($notification->data['accept'])
    User <b>{!! $notification->data['email'] !!}</b> accept invitation
@else
    User <b>{!! $notification->data['email'] !!}</b> decline invitation
@endif