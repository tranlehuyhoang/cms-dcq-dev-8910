@extends('layouts.app')
@section('title')
    {{ __('messages.skills') }}
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.skills') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.skills') }}</li>
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
                                        <form action="#" method="GET">
                                            <input id=" " name="search" type="text" placeholder="Search" class="form-control" autocomplete="on">
                                        </form>
                                    </div>
                                    <a id="demo-btn-addrow" class="btn btn-primary" href="{{ route('skill.add') }}"><i class="mdi mdi-plus-circle me-2"></i> Add New Skills</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                    <thead>
                                        <tr>
                                            <th scope="col">Skill ID</th>
                                            <th scope="col">Skills</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach($arSkills as $key => $skill){
                                            ?>
                                            <tr>
                                                <td><?php echo $skill['id'] ?></td>
                                                <td>
                                                    <a href="{{ route('skill.edit', $skill['id']) }}"><?php echo $skill['name'] ?></a>
                                                </td>
                                                <td>
                                                    <ul class="list-inline table-action m-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('skill.edit', $skill['id']) }}"
                                                                class="action-icon px-1"> <i
                                                                    class="mdi mdi-square-edit-outline"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <div class="dropdown">
                                                                <a class="action-icon px-1 dropdown-toggle"
                                                                    href="#" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="mdi mdi-dots-vertical"></i>
                                                                </a>

                                                                <div
                                                                    class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('skill.destroy', $skill['id']) }}">Delete</a>
                                                                    <a class="dropdown-item"
                                                                        href="#">Another action</a>
                                                                    <a class="dropdown-item"
                                                                        href="#">Something else
                                                                        here</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>

                                    <tfoot>
                                    <tr class="active">
                                        <td colspan="6">
                                            <div>
                                                {{ $paginatePage->appends(request()->query())->links() }}
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
