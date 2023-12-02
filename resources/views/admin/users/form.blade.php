@include('components.errors')

<div class="card-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="name">{{__('admin.user.name')}}</label>
                <input type="text" name="name" id="name" value="{{$model->name}}"
                       class="form-control" autocomplete="off">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="surname">{{__('admin.user.lastname')}}</label>
                <input type="text" name="surname" id="surname" value="{{$model->surname}}"
                       class="form-control" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="patronymic">{{__('admin.user.patronymic')}}</label>
        <input type="text" name="patronymic" id="patronymic" value="{{$model->patronymic}}"
               class="form-control" autocomplete="off">
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="username">{{__('admin.user.username')}}</label>
                <input type="text" name="username" id="username" value="{{$model->username}}"
                       class="form-control" autocomplete="off">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="password">{{__('admin.user.password')}}</label>
                <input type="password" name="password" id="password" class="form-control"
                       @if($model->password) placeholder="******" @endif>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="role_id">{{__('admin.user.role')}}</label>
        <select name="role_id" id="role_id" onchange="changeRole(this.value)"
                class="form-control">
            <option value="">{{__('admin.user.select_role')}}</option>
            @foreach($roles as $key => $role)
                <option value="{{$key}}"
                @if($key == $model->role_id){{'selected'}}@endif>{{$role}}</option>
            @endforeach
        </select>
    </div>

    <div id="organs" class="form-group" style="display: none">
        <label for="organ_id">{{__('admin.user.organ')}}</label>
        <select name="organ_id" id="organ_id" class="form-control">
            <option value="">{{__('admin.user.select_organ')}}</option>
        </select>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="locale">{{__('admin.user.locale')}}</label>
                <select name="locale" id="locale" class="form-control">
                    <option value="uz">{{__('admin.uz')}}</option>
                    <option value="uzk"
                            @if($model->locale == 'uzk') selected @endif>{{__('admin.uzk')}}</option>
                </select>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="position">{{__('admin.user.position')}}</label>
                <input type="text" name="position" id="position" value="{{$model->position}}"
                       class="form-control" autocomplete="off">
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        let organId = {{$model->organ_id + 0}};
        let organs = $('#organs');
        let organ = $('#organ_id');

        function changeRole(role) {
            if (!role || [1, 2, 5].includes(parseInt(role))) { // TODO work with constants
                organs.hide(250);
                organ.attr('required', false);
                organ.val(null); // organ.prop('disabled', true)

                return;
            }

            organs.show(250);
            $.ajax({
                url: '{{route('admin.change_role')}}' + `/${role}`,
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    dynamicSelect(data);
                }
            });
        }

        function dynamicSelect(data) {
            organ.prop('disabled', false);

            organ.children().each((index, e) => { // Remove all options
                if (index !== 0) {
                    e.remove();
                }
            });

            let j = 0; // Only not showing warnings. It's working less 'j'
            for (let i in data) {
                j = i;
                let option = document.createElement('option');
                if (organId === parseInt(j))
                    option.selected = true;

                option.value = j;
                option.text = data[j];
                organ.append(option);
            }
        }

        $(document).ready(function() {
            changeRole({{$model->role_id}});
        })
    </script>
@endsection
