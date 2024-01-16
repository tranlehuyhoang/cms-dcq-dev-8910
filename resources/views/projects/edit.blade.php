@extends('layouts.app')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.project_edit') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('messages.projects') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.project_edit') }}</li>
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
                            <form method="post" id="project_form" accept-charset="UTF-8" enctype="multipart/form-data" action="{{ route('project.update') }}" data-plugin="dropzone" data-previews-container="#file-previews"
                            data-upload-preview-template="#uploadPreviewTemplate">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="project[id]" value="<?php echo $project[0]['id']?>">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.code') }}</label>
                                        <input type="text" name="project[code]" class="form-control" value="<?php echo $project[0]['code']?>" readonly="">
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.name') }}</label>
                                        <input type="text" name="project[name]" class="form-control" value="<?php echo $project[0]['name']?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.budget') }}</label>
                                        
                                        <div class="input-group">
                                            <span class="input-group-text">{{ __('messages.vnd') }}</span>
                                            <input type="number" class="form-control" name="project[budget]" value="<?php echo $project[0]['budget']?>">
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
                                                if ($id == $project[0]['customer_id']) {
                                                    $select = 'selected';
                                                } else {
                                                    $select = '';
                                                }
                                                
                                                ?>
                                                <option <?php echo $select?> value="<?php echo $id?>"><?php echo $name?></option>
                                                <?php
                                            };
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.due_date') }}</label>
                                        <input type="datetime-local" class="form-control" name="project[due_date]" value="<?php echo $project[0]['due_date']?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.description') }}</label>
                                    <textarea style="display: none;" name="project[description]"></textarea>
                                    <div id="snow-editor" style="height: 300px;">
                                        <?php echo $project[0]['description']?>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.upload_file') }}</label>
                                    <div class="d-flex">
                                        <?php
                                        foreach ($arDoc as $doc) {
                                            $ext = pathinfo($doc->file_name, PATHINFO_EXTENSION);
                                            ?>
                                            <div class="card border mb-2 me-1">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar-sm">
                                                                <span class="avatar-title badge-soft-primary text-primary rounded"><?php echo $ext;?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-0">
                                                            <a href="<?php echo $doc->getFullUrl();?>" class="text-muted fw-semibold" download><?php echo $doc->file_name?></a>
                                                            <p class="mb-0 font-12"><?php echo ceil($doc->size/1000)?> KB</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <!-- Button -->
                                                            <a href="javascript:void(0);" class="btn btn-link font-16 text-muted">
                                                                <i class="ri-download-2-line"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        
                                        
                                    </div>
                                    <input name="project[file]" type="file" multiple />
                                    
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a class="btn btn-secondary waves-effect ms-2" href="{{ route('projects.index') }}">Cancel</a>
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
