@extends('layouts.app')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.skill_edit') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('skill.index') }}">{{ __('messages.skills') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.skill_edit') }}</li>
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
                            <form method="post" id="project_form" accept-charset="UTF-8" enctype="multipart/form-data" action="{{ route('skill.update') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="skill[id]" value="<?php echo $skill[0]['id'] ?>">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.name') }}</label>
                                        <input type="text" name="skill[name]" class="form-control" value="<?php echo $skill[0]['name'] ?>">
                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a class="btn btn-secondary waves-effect ms-2" href="{{ route('skill.index') }}">Cancel</a>
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
