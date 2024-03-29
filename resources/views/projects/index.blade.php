@extends('layouts.app')
@section('title')
    {{ __('messages.projects') }}
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.projects') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.projects') }}</li>
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
                            <div class="mb-2">
                                <div class="row row-cols-lg-auto g-2 align-items-center">
                                    <div class="col-12">
                                        <div>
                                            <select id="demo-foo-filter-status" class="form-select">
                                                <option value="">Show all</option>
                                                <option value="active">Active</option>
                                                <option value="disabled">Disabled</option>
                                                <option value="suspended">Suspended</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <input id="demo-foo-search" type="text" placeholder="Search" class="form-control" autocomplete="on">
                                    </div>
                                    <a id="demo-btn-addrow" class="btn btn-primary" href="{{ route('project.add') }}"><i class="mdi mdi-plus-circle me-2"></i> Add New Projects</a>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                    <thead>
                                        <tr>
                                            <th data-toggle="true">Project ID</th>
                                            <th>Projects</th>
                                            <th data-hide="phone">Customer</th>
                                            <th data-hide="phone, tablet">Due Date</th>
                                            <th>Progress</th>
                                            <th data-hide="phone, tablet">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($arProjects as $key => $project) {
                                            if ($project['status'] == 'active') {
                                                $status = 'bg-success';
                                            } elseif ($project['status'] == 'pending') {
                                                $status = 'bg-secondary';
                                            } elseif ($project['status'] == 'deactive') {
                                                $status = 'bg-danger';
                                            }

                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $project['code']?>
                                                </td>
                                                <td>
                                                    <a href="{{ route('project.edit', $project['id']) }}"><?php echo $project['name']?></a>
                                                </td>
                                                <td><?php echo $project['project_customer']['name']?></td>
                                                <td><?php echo \Illuminate\Support\Carbon::parse($project['due_date'])->format('d/m/Y H:i')?></td>
                                                <td><?php echo $project['progress']?>%</td>
                                                <td><span class="badge label-table <?php echo $status;?>"><?php echo $project['status']?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    
                                    </tbody>
                                    <tfoot>
                                    <tr class="active">
                                        <td colspan="6">
                                            <div>
                                                <ul class="pagination pagination-rounded justify-content-end footable-pagination mb-0"><li class="footable-page-arrow disabled"><a data-page="first" href="#first">«</a></li><li class="footable-page-arrow disabled"><a data-page="prev" href="#prev">‹</a></li><li class="footable-page active"><a data-page="0" href="#">1</a></li><li class="footable-page"><a data-page="1" href="#">2</a></li><li class="footable-page"><a data-page="2" href="#">3</a></li><li class="footable-page"><a data-page="3" href="#">4</a></li><li class="footable-page"><a data-page="4" href="#">5</a></li><li class="footable-page-arrow"><a data-page="next" href="#next">›</a></li><li class="footable-page-arrow"><a data-page="last" href="#last">»</a></li></ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card -->
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