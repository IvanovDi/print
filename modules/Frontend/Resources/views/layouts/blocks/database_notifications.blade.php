@foreach($notifications as $notification)
    <li>
        <a href="">
            @if (isset($notification->data['company_id']))
                <?php $company = \Modules\Frontend\Entities\User::find($notification->data['company_id']); ?>
            @endif
            @include('frontend::layouts.blocks.notifications.' . snake_case(class_basename($notification->type)), [
                'notification' => $notification,
                'company' => $company,
            ])
        </a>
    </li>
@endforeach
<li style="text-align: center">
    <a href="{!! route('frontend.profile.showNotifications') !!}" style="display: inline-block;">
        Show all
    </a>
    @if ($count > 0)
        <a href="{!! route('frontend.profile.markAsReadAllNotifications') !!}" style="display: inline-block;">
            Mark all as read
        </a>
    @endif
</li>