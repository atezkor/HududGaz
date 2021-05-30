@extends('secondary')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/extra/summernote.min.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    @if ($model->status == 3)
                        <h3>@lang('district.recommendation.heading_edit')</h3>
                    @else
                        <h3>@lang('district.recommendation.heading_create')</h3>
                    @endif
                    </div>
                    <form id="form" action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('components.errors')
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('district.recommendation.heading')</h3>
                                </div>
                                <div class="card-body">
                                    @include("district.control.$type")
                                    <input type="hidden" name="proposition_id" value="{{$proposition}}">
                                    <input type="hidden" name="type" value="{{$type}}">

                                    @if ($model->status == 3)
                                    <div class="col-12 mt-5">
                                        <div class="form-group">
                                            <label for="file">@lang('district.file')</label>
                                            <div class="custom-file">
                                                <input type="file" name="file" id="file" class="custom-file-input" required>
                                                <label class="custom-file-label" for="file">
                                                    <span id="file_hint">@lang('district.file_hint')</span>
                                                    <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        @if ($model->status == 3)
                            <button type="submit" id="submit" class="btn btn-primary mr-2">@lang('global.btn_upd')</button>
                        @else
                            <button type="submit" id="submit" class="btn btn-primary mr-2">@lang('global.btn_save')</button>
                        @endif
                            <a href="{{$back}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">@lang('global.btn_reset')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('javascript')
<!-- For text editor -->
<script src="{{'/js/jquery.min.js'}}"></script>
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/extra/summernote.min.js'}}"></script>
<script>
    let count = 0;
    let equips_input = $('#equips');
    class Equipment {
        constructor() {
            this.equipment = '';
            this.type = '';
            this.number = 0;
        }
    }

    let equips = [];

    let submit = $('#submit');
    $(function() {
        if ('{{$type}}' === 'accept') {
            submit.attr('disabled', true);
        }
    });

    submit.on('click', function() {
        equips_input.val(JSON.stringify(equips));
    });

    function addEquipment() {
        submit.attr('disabled', false);
        ajax("{{route('district.equipment.add')}}", function(data) {
            create(data);
        });
    }

    function ajax(url, callback) {
        $.ajax({
            url: url,
            dataType: 'json',
            success: function(data) {
                callback(data);
            }
        });
    }

    function create(data) {
        let equipments = $('#equipments');
        let row = document.createElement('div');
        let row2 = document.createElement('div');
        let col = document.createElement('div');
        let col2 = document.createElement('div');

        let equipment = document.createElement('select');
        let type = document.createElement('select');
        let number = document.createElement('input');
        let btn = document.createElement('button');
        append(equipment, 'equipment', "@lang('district.equipment.name')");
        append(type, 'type', "@lang('district.equipment.type')");
        append(number, 'number', "@lang('district.equipment.number')", "@lang('district.equipment.number_hint')");
        append(btn, '', '', '', 'btn btn-danger', '');

        fill(equipment, data, "@lang('district.equipment.name_hint')");
        fill(type, [], "@lang('district.equipment.type_hint')");

        equipment.onchange = function(e) {
            if (!e.target.value)
                return;

            $(type).empty();
            equips[equipment.hint][equipment.name] = equipment.value;
            equips[equipment.hint][type.name] = '';
            ajax("{{route('district.equipment.type')}}" + `/${e.target.value}`, function(data) {
                fill(type, data, "@lang('district.equipment.type_hint')");
            });
        }

        count ++;
        row.id = `row-${count}`;
        row.classList.add('row', 'align-items-end', 'mb-3');
        row.style.display = "none";
        col.classList.add('col-11');
        col2.classList.add('col-1');
        row2.classList.add('row');

        row.append(col, col2);
        col.append(row2);
        equipments.append(row);
        $(`#row-${count}`).show(300);
        equips.push(new Equipment());

        function append(element, name, label, placeholder, classes = 'form-control') {
            let div = document.createElement('div');
            div.classList.add('col-4');
            if (label) {
                let l = document.createElement('label');
                l.textContent = label;
                l.htmlFor = name;
                div.append(l);
            }

            setProperty(element, name, placeholder);

            for (let cls of classes.split(' ')) {
                element.classList.add(cls);
            }

            div.append(element);
            if (label) {
                row2.append(div);
            } else {
                div.classList.remove('col-4');
                div.classList.add('row', 'justify-content-end', 'pr-3');
                col2.append(div);
            }
        }

        function setProperty(element, name, placeholder) {
            if (name) {
                element.name = name;
                element.id = name + '-' + (count + 1);
                element.placeholder = placeholder;
                element.required = true;
                element.hint = count;
                element.onchange = function() {
                    equips[element.hint][name] = element.value;
                    equips_input.val(JSON.stringify(equips));
                }

                element.onkeyup = function() {
                    equips_input.val(JSON.stringify(equips));
                }
            } else {
                element.innerHTML = '<i class="fas fa-minus"></i>';
                element.title = "@lang('global.btn_del')";
                element.type = 'button';
                element.id = count + 1;
                element.onclick = function() {
                    if (count === parseInt(element.id)) {
                        $(`#row-${element.id}`).hide(300, function() {
                            $(this).remove();
                            equips.pop();
                            count --;
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: "@lang('district.equipment.warning')",
                            confirmButtonText: "<i class='fas fa-check'></i>"
                        });
                    }
                };
            }

            if (name === 'number') {
                element.type = name;
            }
        }

        function fill(element, data, first = '') {
            let option = document.createElement('option');
            option.value = '';
            option.text = first;
            element.append(option);

            let j = 0;
            for (let i in data) {
                j = i;
                option = document.createElement('option');
                option.value = j;
                option.text = data[j];
                element.append(option);
            }
        }
    }

    $(document).ready(function() {
        $('#additional').summernote();

        $('input').each(function(){
            this.oninvalid = () => {
                this.setCustomValidity("@lang('district.recommendation.required')");
            }
            this.oninput = () => {
                this.setCustomValidity('');
            }
        })
    });

    $('#file').change(function(input) {
        try {
            $('#file_hint').text(input.target.files[0].name);
        } catch (e) {}
    })

    $('#reset').on('click', function() {
        $('#file_hint').text("@lang('district.file_hint')");
    });
</script>
@endsection
