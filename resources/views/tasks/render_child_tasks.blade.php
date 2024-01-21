<?php
foreach ($arTasks as $key => $value) {

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
   
   $strClass = '';
   foreach ($value['parentIds'] as $parentId) {
       $strClass .= 'child_tasks_'.$parentId. ' ' ;
   }

   ?>
<tr id="child_{{ $value['id'] }}"
    class="child_tasks_{{ $value['parent_id'] }} child_tasks_level_{{ $value['level'] }} <?php echo $strClass; ?>">
    <td>
        <label class="ps-1 label-task form-check-label <?php echo $classStatus; ?> ms-<?php echo $value['level']; ?>" for="tasktodayCheck01">
            <span class="task-arrow">
                <?php
                   if ($value['hasChildren']) {
                       ?>
                <i class="fe-chevron-right" onclick="showChildTasks(this, '<?php echo $value['id']; ?>')"
                    id="<?php echo $value['id']; ?>"></i>
                <?php
                   }
                   ?>
            </span>
            #<?php echo $value['id']; ?>
        </label>
    </td>
    <td>
        <a class="<?php echo $classStatus; ?>" href="{{ route('task.detail', $value['id']) }}"><?php echo $value['name']; ?></a>
    </td>
    <td>
        <div>
            <img src="<?php echo $value['avatar']; ?>" alt="image" class="avatar-sm img-thumbnail rounded-circle"
                title="Houston Fritz" />
            <a class="<?php echo $classStatus; ?>"
                href="{{ route('user.detail', $value['tasks_assign_to']['id']) }}"><?php echo $value['tasks_assign_to']['name']; ?></a>
        </div>
    </td>
    <td>
        <span class="<?php echo $classStatus; ?>"><?php echo \Illuminate\Support\Carbon::parse($value['due_date'])->format('d/m/Y H:i'); ?></span>
    </td>
    <td>
        <span class="badge <?php echo $priority; ?> p-1 <?php echo $classStatus; ?>"><?php echo $value['priority']; ?></span>
    </td>
    <td>
        <span class="<?php echo $classStatus; ?>"><?php echo $value['status']; ?></span>
    </td>
    <td>
        @if ($role == 'admin')
            {{-- Code to be executed if the role is not 'admin' --}}
        @else
            <ul class="list-inline table-action m-0">
                <li class="list-inline-item">
                    <a href="{{ route('task.edit', $value['id']) }}" class="action-icon px-1">
                        <i class="mdi mdi-square-edit-outline"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <div class="dropdown">
                        <a class="action-icon px-1 dropdown-toggle" href="#" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop_{{ $value['id'] }}">Report</a>
                        </div>
                    </div>
                </li>
            </ul>
        @endif
    </td>
    <div class="modal fade" id="staticBackdrop_{{ $value['id'] }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title :
                        _{{ $value['id'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
</tr>

<?php
}
?>
