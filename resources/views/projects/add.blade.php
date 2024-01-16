@extends('layouts.app')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.project_add_new') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('messages.projects') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.project_add_new') }}</li>
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
                            <form method="post" id="project_form" accept-charset="UTF-8" enctype="multipart/form-data" action="{{ route('project.update') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="project[id]" value="0">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.code') }}</label>
                                        <input type="text" name="project[code]" class="form-control" value="">
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.name') }}</label>
                                        <input type="text" name="project[name]" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.budget') }}</label>
                                        
                                        <div class="input-group">
                                            <span class="input-group-text">{{ __('messages.vnd') }}</span>
                                            <input type="number" class="form-control" name="project[budget]">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.status') }}</label>
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="project[status]" id="status1" value="active" checked="">
                                                <label class="form-check-label" for="status1">Active</label>
                                            </div>
                                            <div class="form-check ms-2">
                                                <input class="form-check-input" type="radio" name="project[status]" id="status2" value="pending">
                                                <label class="form-check-label" for="status2">Pending</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.customer') }}</label>
                                        <select id="project_customer" class="form-control" name="project[customer_id]">
                                            <?php
                                            foreach ($arCustomer as $id => $name) {
                                                ?>
                                                <option value="<?php echo $id?>"><?php echo $name?></option>
                                                <?php
                                            };
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.due_date') }}</label>
                                        <input type="datetime-local" class="form-control" name="project[due_date]">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.description') }}</label>
                                    <textarea style="display: none;" name="project[description]"></textarea>
                                    <div id="snow-editor" style="height: 300px;">
                                        
                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a class="btn btn-secondary waves-effect ms-2" href="{{ route('task.index') }}">Cancel</a>
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
                    <script>document.write(new Date().getFullYear())</script> &copy; Minton theme by <a href="">Coderthemes</a> 
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
