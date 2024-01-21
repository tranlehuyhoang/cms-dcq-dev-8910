@extends('layouts.app')
@section('title')
    {{ __('messages.notifications') }}
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.notification_edit') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dcq') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('notifications') }}">{{ __('messages.notifications') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.notification_edit') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form id="task_form" accept-charset="UTF-8">
                                <div class="  mb-3">
                                    <label class="form-label">{{ __('messages.title') }}</label>

                                    <input readonly type="text" name="title" class="form-control"
                                        value="{{ $notification->title }}">
                                    </input>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">{{ __('messages.content') }}</label>
                                        <br>
                                        <?php echo $notification->content; ?>


                                    </div>




                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->




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
