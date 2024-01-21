@extends('layouts.app')
@section('title')
    {{ __('messages.tasks') }}
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.notification_create') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dcq') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('task.index') }}">{{ __('messages.notifications') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.notification_create') }}</li>
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
                            <form method="post" id="task_form" accept-charset="UTF-8" enctype="multipart/form-data"
                                action="{{ route('notifications.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.title') }}</label>
                                    <input type="text" name="title" class="form-control" value="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.content') }}</label>
                                    <textarea name="content" id="editor"></textarea>

                                    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#editor'))
                                            .catch(error => {
                                                console.error(error);
                                            });
                                    </script>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">{{ __('messages.receiver') }}</label>

                                    <div class="d-flex gap-1">

                                        <select class="js-example-basic-multiple" name="selected_users[]"
                                            multiple="multiple">
                                            @foreach ($users as $user)
                                                <option class="badge badge-soft-success " value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                        <script>
                                            $(document).ready(function() {
                                                $('.js-example-basic-multiple').select2();
                                            });
                                        </script>
                                        <style>
                                            .select2-selection__choice {
                                                color: #1abc9c !important;
                                                background-color: rgba(26, 188, 156, .18) !important;
                                                border: 0px !important;
                                            }
                                        </style>
                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a class="btn btn-secondary waves-effect ms-2"
                                        href="{{ route('task.index') }}">Cancel</a>
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
