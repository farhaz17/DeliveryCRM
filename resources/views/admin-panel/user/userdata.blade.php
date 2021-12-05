    <div class="row">
        <div class="col">
            <h5 class="card-title mb-2">User Role</h5>
            <ul class="list-group">
                @foreach($userGroup as $role)
                    <li class="list-group-item" style="padding: 3px">{{ ucfirst ( $role->name ?? "" ) }}</li>
                @endforeach
            </ul>
            <hr>
            <h5 class="card-title mb-2">User Permission Role</h5>
            <ul class="list-group">
                @foreach($permissions as $permission)
                    <li class="list-group-item" style="padding: 3px">{{ ucfirst ( $permission->name ?? "" ) }}</li>
                @endforeach
            </ul>
        <hr>
            <h5 class="card-title mb-2">Major Departments</h5>
            <ul class="list-group">
                @foreach($major_department as $major_department)
                    <li class="list-group-item" style="padding: 3px">{{ ucfirst ( $major_department->major_department ?? "" )}}</li>
                @endforeach
            </ul>
        </div>
        <div class="col">
            <h5 class="card-title mb-2">PlatForms</h5>
            <ul class="list-group">
                @foreach($userPlatform as $userPlatform)
                    <li class="list-group-item" style="padding: 3px">{{ ucfirst ( $userPlatform->name ?? "" ) }}</li>
                @endforeach
            </ul>
        </div>
    </div>
