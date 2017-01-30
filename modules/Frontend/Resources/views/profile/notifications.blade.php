@extends('frontend::layouts.master')

@section('title')
    Notifications
@stop

@section('breadcrumb')
    <li class="active">Notifications</li>
@stop

@section('content')
    <h1>
        Notifications
        <a href="{!! route('frontend.profile.markAsReadAllNotifications') !!}" class="btn btn-default pull-right">
            Mark all as read
        </a>
    </h1>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th>Message</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
                <tr @if ($notification->read_at === null) class="danger" @endif>
                    <td>
                        @if (isset($notification->data['company_id']))
                            <?php $company = \Modules\Frontend\Entities\User::find($notification->data['company_id']); ?>
                        @endif
                        @include('frontend::layouts.blocks.notifications.' . snake_case(class_basename($notification->type)), [
                            'notification' => $notification,
                            'company' => $company,
                        ])
                    </td>
                    <td>
                        {!! $notification->created_at !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $notifications->render() !!}
@stop