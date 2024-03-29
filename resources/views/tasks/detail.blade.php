@extends('layouts.app')
@section('content')
    <div class="content">
        {{-- @dd(get_defined_vars()); --}}
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('messages.task_detail') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dcq') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('task.index') }}">{{ __('messages.tasks') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.task_detail') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($task[0]['assign_to'] ==  $user_id ) {
?>
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class='mdi mdi-dots-horizontal font-18'></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">

                                    <a type="button" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop_{{ $task[0]['id'] }}">Report</a>

                                </div>
                            </div>
                            <?php
                            }else if ($role == 'admin') {
                                ?>

                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class='mdi mdi-dots-horizontal font-18'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a type="button" class="dropdown-item">Edit</a>
                                    <a type="button" class="dropdown-item">Delete</a>

                                </div>
                            </div>
                            <?php
                            }else{
                              ?>


                            <?php
} ?>


                            <div class="modal fade" id="staticBackdrop_{{ $task[0]['id'] }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" id="task_form" accept-charset="UTF-8"
                                            enctype="multipart/form-data" action="{{ route('notifications.report_task') }}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Report task id:
                                                    {{ $task[0]['id'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="text" name="task_id" value="{{ $task[0]['id'] }}" hidden
                                                    class="form-control" />
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.title') }}</label>
                                                    <input type="text" name="title" class="form-control"
                                                        value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.content') }}</label>
                                                    <textarea name="content" id="editor_{{ $task[0]['id'] }}"></textarea>

                                                    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
                                                    <script>
                                                        ClassicEditor
                                                            .create(document.querySelector('#editor_{{ $task[0]['id'] }}'))
                                                            .catch(error => {
                                                                console.error(error);
                                                            });
                                                    </script>


                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-1"><?php echo $task[0]['name']; ?></h4>

                            <div class="text-muted">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-start mt-3">
                                            <div class="me-2 align-self-center">
                                                <img src="<?php echo $avatar; ?>" alt=""
                                                    class="avatar-sm rounded-circle">
                                            </div>
                                            <div class="flex-1 overflow-hidden">
                                                <p class="mb-1">Assign to</p>
                                                <h5 class="mt-0 text-truncate">
                                                    <?php echo $task[0]['tasks_assign_to']['name']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-start mt-3">
                                            <div class="me-2 align-self-center">
                                                <i class="ri-calendar-event-line h2 m-0 text-muted"></i>
                                            </div>
                                            <div class="flex-1 overflow-hidden">
                                                <p class="mb-1">Due Date</p>
                                                <h5 class="mt-0 text-truncate">
                                                    <?php echo \Illuminate\Support\Carbon::parse($task[0]['due_date'])->format('d/m/Y H:i'); ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5>{{ __('messages.task_description') }}</h5>
                                <div class="border rounded-1 p-2 overflow-auto">
                                    <?php echo $task[0]['description']; ?>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-4">
                                        <h5>{{ __('messages.task_task_value') }}</h5>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ __('messages.task_hour') }}</span>
                                            <input type="number" step="0.125" class="form-control"
                                                value="<?php echo $task[0]['task_value']; ?>" name="task[task_value]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <h5>{{ __('messages.task_status') }}</h5>
                                        <span class="btn btn-secondary waves-effect"><?php echo $arStatus[$task[0]['status']]; ?></span>
                                    </div>

                                    <div class="col-4">
                                        <h5>{{ __('messages.task_priority') }}</h5>
                                        <span class="btn btn-secondary waves-effect"><?php echo $arPriority[$task[0]['priority']]; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class='mdi mdi-dots-horizontal font-18'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class='mdi mdi-attachment me-1'></i>Attachment
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class='mdi mdi-pencil-outline me-1'></i>Edit
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class='mdi mdi-content-copy me-1'></i>Mark as Duplicate
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item text-danger">
                                        <i class='mdi mdi-delete-outline me-1'></i>Delete
                                    </a>
                                </div> <!-- end dropdown menu-->
                            </div> <!-- end dropdown-->
                            <h5 class="header-title mb-3">Attachments</h5>

                            <div class="row">
                                <div class="col-md-6" <?php echo $role == 'admin' ? '' : 'hidden'; ?>>
                                    <div>
                                        <form action="{{ route('task.upload_media') }}" method="post" class="dropzone"
                                            id="myAwesomeDropzone" data-plugin="dropzone"
                                            data-previews-container="#file-previews"
                                            data-upload-preview-template="#uploadPreviewTemplate"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input name="task_id" hidden type="text" value="{{ $task_id }}" />
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>

                                            <div class="dz-message needsclick">
                                                <i class="h2 text-muted ri-upload-2-line d-inline-block"></i>
                                                <h4>Drop files here or click to upload.</h4>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mt-4 mt-md-0">

                                        @if ($media)
                                            @foreach ($media as $item)
                                                <div class="card border mb-2">
                                                    <div class="p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <div class="avatar-sm">
                                                                    <span
                                                                        class="avatar-title badge-soft-primary text-primary rounded">
                                                                        {{ strtoupper(Str::after($item->file_name, '.')) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col ps-0">
                                                                <a href="{{ $item->getUrl() }}" download=""
                                                                    class="text-muted fw-semibold">{{ $item->name }}</a>
                                                                <p class="mb-0 font-12">
                                                                    {{ round($item->size / 1024 / 1024, 2) }} MB
                                                                </p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <!-- Button -->
                                                                <a href="{{ $item->getUrl() }}" download=""
                                                                    class="btn btn-link font-16 text-muted">
                                                                    <i class="ri-download-2-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>Không có media cho task này.</p>
                                        @endif
                                        <!-- Preview -->
                                        <div class="dropzone-previews mt-2" id="file-previews"></div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php
                    if (count($arChildTasks) > 0) {
                        ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title mb-3">Child tasks</h5>

                            <div class="table-responsive mt-3">
                                <table class="table table-centered table-nowrap table-borderless table-sm">
                                    <thead class="table-light">
                                        <tr class="">

                                            <th scope="col">
                                                Task ID
                                            </th>
                                            <th scope="col">Tasks</th>
                                            <th scope="col">Assign to</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($arChildTasks as $key => $value) {
                                            if ($value['project_id'] != $project_id) {
                                                continue;
                                            }
                                            if ($value['priority'] == 'hight') {
                                                $priority = 'badge-soft-danger';
                                            } elseif ($value['priority'] == 'medium') {
                                                $priority = 'badge-soft-info';
                                            } else {
                                                $priority = 'badge-soft-success';
                                            }

                                            if ($value['status'] == 'complete') {
                                                $classStatus = 'complete-task';
                                                $priority = '';
                                            } else {
                                                $classStatus = '';
                                            }
                                            
                                            ?>
                                        <tr id="child_{{ $value['id'] }}"
                                            class="child_tasks_<?php echo $value['parent_id']; ?> child_tasks_level_<?php echo $value['level']; ?>">
                                            <td>

                                                <label class="ps-1 label-task form-check-label <?php echo $classStatus; ?>"
                                                    for="tasktodayCheck01">
                                                    <span class="task-arrow">
                                                        <?php
                                                            if ($value['hasChildren']) {
                                                                ?>
                                                        <i class="fe-chevron-right"
                                                            onclick="showChildTasks(this, '<?php echo $value['id']; ?>')"
                                                            id="<?php echo $value['id']; ?>"></i>
                                                        <?php
                                                            }
                                                            ?>
                                                    </span>
                                                    #<?php echo $value['id']; ?>
                                                </label>
                                            </td>
                                            <td>
                                                <a class="<?php echo $classStatus; ?>"
                                                    href="{{ route('task.detail', $value['id']) }}">
                                                    <?php echo strlen($value['name']) > 10 ? substr($value['name'], 0, 10) . '...' : $value['name']; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <div>

                                                    <img src="<?php echo $value['avatar']; ?>" alt="image"
                                                        class="avatar-sm img-thumbnail rounded-circle"
                                                        title="Houston Fritz" />
                                                    <a class="<?php echo $classStatus; ?>"
                                                        href="{{ route('user.detail', $value['tasks_assign_to']['id']) }}">
                                                        <?php echo strlen($value['tasks_assign_to']['name']) > 10 ? substr($value['tasks_assign_to']['name'], 0, 10) . '...' : $value['tasks_assign_to']['name']; ?>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="<?php echo $classStatus; ?>"><?php echo \Illuminate\Support\Carbon::parse($value['due_date'])->format('d/m/Y H:i'); ?></span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge <?php echo $priority; ?> p-1 <?php echo $classStatus; ?>"><?php echo $value['priority']; ?></span>
                                            </td>
                                            <td>
                                                <span class="<?php echo $classStatus; ?>">
                                                    <?php echo $value['status']; ?>
                                                </span>
                                            </td>

                                        </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <script>
                    showChildTasks = function(element, id) {

                        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        var element = $('i.fe-chevron-right#' + id);

                        if (element.hasClass('fe-chevron-right')) {
                            $.ajax({
                                url: '{{ route('task.get_child_tasks') }}',
                                method: 'POST',
                                data: {
                                    id: id,
                                    _token: '{{ csrf_token() }}' // Thêm mã CSRF vào yêu cầu
                                },
                                success: function(response) {
                                    var child_tasks = response.html;
                                    $('#child_' + id).after(child_tasks);

                                    element.removeClass('fe-chevron-right').addClass('fe-chevron-down');
                                },
                                error: function(xhr, status, error) {
                                    // Xử lý lỗi
                                    console.error(error);
                                }
                            });
                        } else {
                            var element = $('i.fe-chevron-down#' + id);

                            element.removeClass('fe-chevron-down').addClass('fe-chevron-right');
                            $('tr.child_tasks_' + id).remove();
                        }

                    }
                </script>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="float-end">
                                <select class="form-select form-select-sm">
                                    <option selected="">Recent</option>
                                    <option value="1">Most Helpful</option>
                                    <option value="2">High to Low</option>
                                    <option value="3">Low to High</option>
                                </select>
                            </div> <!-- end dropdown-->

                            <h4 class="mb-4 mt-0 font-16">Comments ({{ $commentCount }})</h4>

                            <div class="clerfix"></div>

                            @foreach ($taskComments as $taskComment)
                                <div class="d-flex align-items-start mt-3">
                                    <img class="me-2 rounded-circle" src="/assets/images/users/avatar-5.jpg"
                                        alt="Generic placeholder image" height="32">
                                    <div class="flex-1">
                                        <h5 class="mt-0">
                                            {{ $taskComment->user->name }}
                                            <small
                                                class="text-muted fw-normal float-end">{{ $taskComment->created_at->diffForHumans() }}</small>
                                        </h5>
                                        {{ $taskComment->content }}

                                        <br />
                                        <a href="javascript:void(0);" class="text-muted font-13 d-inline-block mt-2"
                                            onclick="setReplyId('{{ $taskComment->id }}', '{{ $taskComment->user->name }}');">
                                            <i class="mdi mdi-reply"></i> Reply
                                        </a>

                                        @if ($taskComment->replyCount > 0)
                                            <a href="javascript:void(0);" class="text-muted font-13 d-inline-block mt-2"
                                                onclick="getReplyComments_level_2('{{ $taskComment->id }}');">
                                                <i class="mdi mdi-arrow-down"></i>
                                                Xem {{ $taskComment->replyCount }} phản hồi
                                            </a>
                                        @endif
                                        <div id="child_{{ $taskComment->id }}"></div>
                                    </div>
                                </div>
                            @endforeach
                            <div id="pagination"></div>
                            <div class="text-center mt-2">
                                <a href="javascript:void(0);" onclick="pagination(1, '{{ $task_id }}')"
                                    class="text-danger"><i class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                            </div>

                            <script>
                                function getReplyComments_level_2(taskCommentId) {
                                    // Gửi yêu cầu AJAX POST
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                    $.ajax({
                                        url: '{{ route('taskcomment.getcommentlevel2') }}',
                                        method: 'POST',
                                        data: {
                                            taskCommentId: taskCommentId,
                                            _token: csrfToken // Thêm mã CSRF vào yêu cầu
                                        },
                                        success: function(response) {
                                            // console.log(response.replyComments.html);
                                            // console.log(response.replyComments.taskComments);
                                            var taskCommentsHTML = response.replyComments.html;
                                            $('#child_' + taskCommentId).html(taskCommentsHTML);
                                        },
                                        error: function(xhr, status, error) {
                                            // Xử lý lỗi
                                            console.error(error);
                                        }
                                    });
                                }

                                function getReplyComments_level_3(taskCommentId) {
                                    // Gửi yêu cầu AJAX POST
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                    $.ajax({
                                        url: '{{ route('taskcomment.getcommentlevel3') }}',
                                        method: 'POST',
                                        data: {
                                            taskCommentId: taskCommentId,
                                            _token: csrfToken // Thêm mã CSRF vào yêu cầu
                                        },
                                        success: function(response) {
                                            console.log(response.html)
                                            var taskCommentsHTML = response.html;
                                            $('#child_' + taskCommentId).html(taskCommentsHTML);
                                        },
                                        error: function(xhr, status, error) {
                                            // Xử lý lỗi
                                            console.error(error);
                                        }
                                    });
                                };
                                var page_id_count = 1;

                                function pagination(page_id, task_id) {
                                    // Gửi yêu cầu AJAX POST
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    $.ajax({
                                        url: '{{ route('taskcomment.pagination') }}',
                                        method: 'POST',
                                        data: {
                                            pageId: page_id_count,
                                            taskId: task_id,
                                            _token: csrfToken // Thêm mã CSRF vào yêu cầu
                                        },
                                        success: function(response) {
                                            var taskCommentsHTML = response.html;
                                            var paginationDiv = document.getElementById('pagination');
                                            paginationDiv.innerHTML += taskCommentsHTML;
                                            page_id_count++;
                                        },
                                        error: function(xhr, status, error) {
                                            // Xử lý lỗi
                                            console.error(error);
                                        }
                                    });
                                }
                            </script>


                            <style>
                                #boldText {
                                    font-weight: bold;
                                }
                            </style>
                            <div class="border rounded mt-4">
                                <span id="boldText"></span>
                                <form id="comment-form" class="comment-area-box">
                                    <input type="number" hidden name="task_id" id="task_id"
                                        value="{{ $task_id }}">
                                    <input type="number" hidden name="reply_id" id="reply_id" value="0"
                                        id="reply_id">

                                    <textarea name="content" id="comment_content" rows="3" class="form-control border-0 resize-none"
                                        placeholder="Your comment..."></textarea>
                                    <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="#" class="btn btn-sm px-1 btn-light"><i
                                                    class='mdi mdi-upload'></i></a>
                                            <a href="#" class="btn btn-sm px-1 btn-light"><i
                                                    class='mdi mdi-at'></i></a>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success"><i
                                                class="fe-send me-1"></i>Submit</button>
                                    </div>
                                </form>

                                <script>
                                    function setReplyId(userId, userName) {
                                        console.log('userId', userId);
                                        document.getElementById('reply_id').value = userId;
                                        var boldText = document.getElementById('boldText');
                                        document.getElementById('comment_content').value = '@' + userName + ' : ';
                                    }

                                    $(document).ready(function() {
                                        $('#comment-form').submit(function(e) {
                                            e.preventDefault(); // Ngăn chặn hành vi mặc định của biểu mẫu

                                            var formData = $(this).serialize(); // Chuyển đổi dữ liệu biểu mẫu thành chuỗi query
                                            var csrfToken = $('meta[name="csrf-token"]').attr(
                                                'content'); // Sử dụng phương thức attr() để lấy giá trị thuộc tính content

                                            // Lấy giá trị của các trường dữ liệu
                                            var task_id = $('#task_id').val();
                                            var content = $('#comment_content').val();
                                            var reply_id = $('#reply_id').val();

                                            $.ajax({
                                                url: "{{ route('taskcomment.create') }}",
                                                type: "POST",
                                                data: {
                                                    task_id: task_id,
                                                    content: content,
                                                    reply_id: reply_id,
                                                    _token: csrfToken // Thêm mã CSRF vào yêu cầu
                                                },
                                                success: function(response) {
                                                    var data = response.html;
                                                    var reply_id = response.reply_id;
                                                    // Xử lý dữ liệu phản hồi sau khi gửi biểu mẫu thành công
                                                    console.log(response);

                                                    // Reset nội dung của các trường dữ liệu
                                                    $('#comment_content').val('');
                                                    $('#reply_id').val('0');

                                                    if (reply_id == 0) {
                                                        $('.clerfix').html(response.html);

                                                    } else {
                                                        $('#child_' + reply_id).html(response.html);

                                                    }
                                                    // Tạo HTML cho comment mới


                                                },
                                                error: function(xhr, status, error) {
                                                    // Xử lý lỗi nếu có
                                                    console.error(error);
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </div> <!-- end .border-->

                        </div> <!-- end card-body-->
                    </div>
                    <!-- end card-->
                </div>
            </div>
            <!-- end row -->

            <!-- file preview template -->
            <div class="d-none" id="uploadPreviewTemplate">
                <div class="card mb-2 shadow-none border">
                    <div class="p-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                <p class="mb-0" data-dz-size></p>
                            </div>
                            <div class="col-auto">
                                <!-- Button -->
                                <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                    <i class="fe-x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
