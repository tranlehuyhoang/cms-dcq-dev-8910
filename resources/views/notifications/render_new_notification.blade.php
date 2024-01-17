@if ($notifications->isEmpty())
    <a href="javascript:void(0);" class="dropdown-item notify-item jutifyle-contencenter">
        <div class=" text-center">
            No notification
        </div>
    </a>
@else
    @foreach ($notifications as $key => $value)
        <a href="javascript:void(0);"
            class="dropdown-item notify-item {{ $value['userHasNotification'][0]['mark_read'] == 1 ? '' : 'active' }}">
            <div class="notify-icon bg-soft-primary text-primary">
                <img src="{{ $value['avatar'] }}" class="img-fluid rounded-circle" alt="" />
            </div>
            <p class="notify-details">{{ $value['content'] }}
                <small class="text-muted">{{ $value['diffForHumansInVietnam'] }}</small>
            </p>
        </a>
    @endforeach
@endif
