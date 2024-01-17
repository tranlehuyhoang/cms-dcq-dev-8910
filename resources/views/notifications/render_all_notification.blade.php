 @foreach ($notifications as $notification)
     <div class="notification">
         <h3>{{ $notification->content }}</h3>
         <p>{{ $notification->content }}</p>
         <p>Created at: {{ $notification->created_at }}</p>
         <p>User: {{ $notification->user->name }}</p>
         <p>User Has Notification: {{ $notification->userHasNotification->user->name }}</p>
     </div>
 @endforeach
