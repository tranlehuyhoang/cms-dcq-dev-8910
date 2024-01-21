@extends('layouts.app')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box page-title-box-alt">
                        <h4 class="page-title">Chat</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                                <li class="breadcrumb-item active">Chat</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <!-- start chat users-->
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex align-items-start align-items-start mb-3">
                                <img src="/assets/images/users/avatar-1.jpg" class="me-2 rounded-circle" height="42"
                                    alt="Brandon Smith">
                                <div class="flex-1">
                                    <h5 class="mt-0 mb-0 font-15">
                                        <a href="contacts-profile.html" class="text-reset">{{ Auth::user()->name }}</a>
                                    </h5>
                                    <p class="mt-1 mb-0 text-muted font-14">
                                        <small class="mdi mdi-circle text-success"></small> Online
                                    </p>
                                </div>
                                <div>
                                    <a href="javascript: void(0);" class="text-reset font-20">
                                        <i class="mdi mdi-cog-outline"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- start search box -->
                            <form method="get" id="task_form" accept-charset="UTF-8" enctype="multipart/form-data">
                                <div class="position-relative">
                                    <input name="search" type="text" class="form-control form-control-light"
                                        value="{{ $_GET['search'] ?? '' }}" placeholder="People, groups & messages...">
                                    <span class="mdi mdi-magnify"></span>
                                </div>
                            </form>
                            <!-- end search box -->

                            <h6 class="font-13 text-muted text-uppercase mb-2">Contacts</h6>

                            <!-- users -->
                            <div class="row">
                                <div class="col">


                                    <div data-simplebar style="max-height: 498px">
                                        @forelse ($sortedUsers as $user)
                                            <a href="{{ route('chat.room', ['id' => $user->id]) }}" class="text-body">
                                                <div class="d-flex align-items-start p-2">
                                                    <div class="position-relative">
                                                        <span class="user-status"></span>
                                                        <img src="/assets/images/users/avatar-2.jpg"
                                                            class="me-2 rounded-circle" height="42" alt="user" />
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="mt-0 mb-0 font-14">
                                                            <span class="float-end text-muted fw-normal font-12">
                                                                {{ \Carbon\Carbon::parse($user->latestChat->created_at ?? '0')->setTimezone('Asia/Ho_Chi_Minh')->format('h:i A') ?? '00:00' }}
                                                            </span>
                                                            {{ $user->name }}
                                                        </h5>
                                                        <p class="mt-1 mb-0 text-muted font-14">
                                                            <span class="w-25 float-end text-end"><span
                                                                    class="badge badge-soft-danger">3</span></span>
                                                            <span

                                                                class="w-75">{{ $user->latestChat->note ?? 'Start new conversation' }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <!-- Empty case content -->
                                        @endforelse



                                    </div> <!-- end slimscroll-->
                                </div> <!-- End col -->
                            </div>
                            <!-- end users -->
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
                <!-- end chat users-->

                <!-- chat area -->
                <div class="col-xl-9 col-lg-8">
                    @isset( $otherUser)
                    <div class="card">
                        <div class="card-body py-2 px-3 border-bottom border-light">
                            <div class="d-flex py-1">
                                <img src="/assets/images/users/avatar-5.jpg" class="me-2 rounded-circle" height="36"
                                    alt="Brandon Smith">
                                <div class="flex-1">
                                    <h5 class="mt-0 mb-0 font-15">
                                        <a href="contacts-profile.html" class="text-reset">{{ $otherUser->name }}</a>
                                    </h5>
                                    <p class="mt-1 mb-0 text-muted font-12">
                                        <small class="mdi mdi-circle text-success"></small> Online
                                    </p>
                                </div>
                                <div id="tooltip-container">
                                    <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                                        <i class="fe-phone-call" data-bs-container="#tooltip-container"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Voice Call"></i>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                                        <i class="fe-video" data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Video Call"></i>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                                        <i class="fe-user-plus" data-bs-container="#tooltip-container"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add Users"></i>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                                        <i class="fe-trash-2" data-bs-container="#tooltip-container"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Chat"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="conversation-list chat-app-conversation" data-simplebar style="max-height: 460px">


                                @forelse ($chats as $chat)
                                    @if ($chat->sender_id == $otherUser->id)
                                        <li class="clearfix">
                                            <div class="chat-avatar">
                                                <img src="/assets/images/users/avatar-5.jpg" class="rounded"
                                                    alt="James Z" />
                                                <i>{{ \Carbon\Carbon::parse($chat->created_at)->setTimezone('Asia/Ho_Chi_Minh')->hour . ':' . \Carbon\Carbon::parse($chat->created_at)->setTimezone('Asia/Ho_Chi_Minh')->minute ?? '00:00 ' }}</i>
                                            </div>
                                            <div class="conversation-text">
                                                <div class="ctext-wrap">
                                                    <i>{{ $otherUser->name }}</i>
                                                    <p>
                                                        {{ $chat->note }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="conversation-actions dropdown">
                                                <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i
                                                        class='mdi mdi-dots-vertical font-18'></i></button>

                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Copy Message</a>
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="clearfix odd">
                                            <div class="chat-avatar">
                                                <img src="/assets/images/users/avatar-1.jpg" class="rounded"
                                                    alt="Nik Patel" />
                                                <i>{{ \Carbon\Carbon::parse($chat->created_at)->setTimezone('Asia/Ho_Chi_Minh')->hour . ':' . \Carbon\Carbon::parse($chat->created_at)->setTimezone('Asia/Ho_Chi_Minh')->minute ?? '00:00 ' }}</i>
                                            </div>
                                            <div class="conversation-text">
                                                <div class="ctext-wrap">
                                                    <i>{{ Auth::user()->name }}</i>
                                                    <p>
                                                        {{ $chat->note }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="conversation-actions dropdown">
                                                <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i
                                                        class='mdi mdi-dots-vertical font-18'></i></button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Copy Message</a>
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @empty
                                    <!-- Empty case content -->
                                @endforelse
                            </ul>

                            <div class="row">
                                <div class="col">
                                    <div class="mt-2 bg-light p-3 rounded">
                                        <form method="post" action="{{ route('chat.add') }}" id="task_form" rou
                                            accept-charset="UTF-8" enctype="multipart/form-data" id="chat-form">
                                            @csrf
                                            <div class="row">

                                                <div class="col mb-2 mb-sm-0">
                                                    <input type="hidden" name="chat_id" value="{{$chatRoom->id}}">

                                                    <input type="text" name="note" class="form-control border-0"
                                                        placeholder="Enter your text" required="">
                                                    <div class="invalid-feedback mt-2">
                                                        Please enter your messsage
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-light"><i
                                                                class="fe-paperclip"></i></a>
                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-success chat-send"><i
                                                                    class='fe-send'></i></button>
                                                        </div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </form>
                                    </div>
                                </div> <!-- end col-->
                            </div>
                            <!-- end row -->
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    @endisset

                </div>
                <!-- end chat area-->

            </div> <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> &copy; Minton theme by <a href="">Coderthemes</a>
                </div>
                <div class="col-md-6">
                    <div class="text-md-end footer-links d-none d-sm-block">
                        <a href="javascript:void(0);">About Us</a>
                        <a href="javascript:void(0);">Help</a>
                        <a href="javascript:void(0);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
@endsection
