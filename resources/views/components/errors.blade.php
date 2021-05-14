@if($errors->any())
    <div class="alert alert-danger">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="list-group-item bg-danger border-warning">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
