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
                        <h4 class="page-title">{{ __('messages.notifications') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.notifications') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <!-- cta -->
                                    <div class="row">
                                        <div class="col-sm-3">

                                        </div>
                                        <div class="col-sm-9">
                                            <div class="float-sm-end mt-3 mt-sm-0">
                                                <div class="d-flex align-items-start flex-wrap">
                                                    <div class="mb-3 mb-sm-0 me-sm-2">
                                                        <form action="{{ url()->current() }}" method="GET">
                                                            <div class="position-relative">
                                                                <input type="text" name="search" class="form-control"
                                                                    placeholder="Search...">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-light dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="mdi mdi-filter-variant"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Due Date</a>
                                                            <a class="dropdown-item" href="#">Added Date</a>
                                                            <a class="dropdown-item" href="#">Assignee</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-accordion">

                                        <div class="mt-4">

                                            <div class="collapse show" id="taskcollapse">
                                                <div class="table-responsive mt-3">
                                                    <table
                                                        class="table table-centered table-nowrap table-borderless table-sm">
                                                        <thead class="table-light">
                                                            <tr class="">
                                                                <th scope="col">
                                                                    ID
                                                                </th>
                                                                <th scope="col">Sender</th>
                                                                <th scope="col">Title</th>
                                                                <th scope="col">Content</th>
                                                                <th scope="col">Edit date</th>
                                                                <th scope="col">Read</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($notifications as $notification)
                                                                <tr id=" " class="child_tasks_ ">
                                                                    <td>

                                                                        <label class="ps-1 label-task form-check-label  "
                                                                            for="tasktodayCheck01">
                                                                            <span class="task-arrow">

                                                                            </span>
                                                                            #<?php echo $notification->id; ?>
                                                                        </label>
                                                                    </td>


                                                                    <td>
                                                                        <span class=""><?php echo $notification->user->name; ?></span>
                                                                    </td>


                                                                    <td>
                                                                        <span class=""><?php echo $notification->title; ?></span>
                                                                    </td>

                                                                    <td>
                                                                        <span class=""><?php echo $notification->content; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class=""><?php echo $notification->diffForHumansInVietnam; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="">
                                                                            @if ($notification->userHasNotification[0]->mark_read == 1)
                                                                                <span
                                                                                    class="badge badge-soft-success p-1">Yes</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-soft-danger p-1">No</span>
                                                                            @endif
                                                                        </span>
                                                                    </td>



                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="pagination">
                                                        {{ $notifications->appends(request()->except('page'))->links() }}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->

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
