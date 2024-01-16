@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.user_edit') }} <?php echo $user[0]['name']; ?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">{{ __('messages.dcq') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('user.index') }}">{{ __('messages.user_member_list') }}</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form method="post" id="task_form" accept-charset="UTF-8" enctype="multipart/form-data"
                                action="{{ route('user.update') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php echo $user[0]['id']; ?>">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_name') }}</label>
                                        <input type="" class="form-control" name="name"
                                            value="<?php echo $user[0]['name']; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_email') }}</label>
                                        <input type="email" class="form-control" aria-describedby="emailHelp"
                                            name="email" value="<?php echo $user[0]['email']; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_country') }}</label>
                                        <input type="" class="form-control" name="country"
                                            value="<?php echo $user[0]['country']; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_phone') }}</label>
                                        <input type="number" class="form-control" name="phone"
                                            value="<?php echo $user[0]['phone']; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_point_accumulated') }}</label>
                                        <input type="number" class="form-control" name="point_accumulated"
                                            value="<?php echo $user[0]['point_accumulated']; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_expertise_coefficient') }}</label>
                                        <input type="number" class="form-control" name="expertise_coefficient"
                                            value="<?php echo $user[0]['expertise_coefficient']; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_allowance') }}</label>
                                        <input type="number" class="form-control" name="allowance"
                                            value="<?php echo $user[0]['allowance']; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_role') }}</label>
                                        <select class="form-control" name="role_id">
                                            <?php
                                        foreach ($arRole as $id => $name) {
                                            if ($id == $user[0]['role_id']) {
                                                $select = 'selected';
                                            } else {
                                                $select = '';
                                            }
                                            
                                            ?>
                                            <option <?php echo $select; ?> value="<?php echo $id; ?>"><?php echo $name; ?>
                                            </option>
                                            <?php
                                        };
                                        ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_password') }}</label>
                                        <input type="password" class="form-control" name="password" value="">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_re_password') }}</label>
                                        <input type="password" class="form-control" name="re_password" value="">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ __('messages.user_avatar') }}</label>

                                        <input type="file" class="form-control" name="avatar">
                                        <?php
                                    foreach($avatarUsers[$user[0]['id']] as $avatar){
                                        ?>
                                        <img src="<?php echo $avatar->getFullUrl(); ?>" class="rounded-circle img-thumbnail avatar-xl mt-1"
                                            alt="profile-image" />
                                        <?php 
                                    }
                                    ?>
                                    </div>
                                    <div class="col-lg-6">


                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-6">

                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a class="btn btn-secondary waves-effect ms-2"
                                        href="{{ route('user.index') }}">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
