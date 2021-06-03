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
                                    <input type="hidden" name="organ" value="{{auth()->user()->organ ?? ''}}">

                                    @if ($model->status == 3)
                                    <div class="col-12 mt-5">
                                        <div class="form-group">
                                            <label for="file">@lang('district.file')</label>
                                            <div class="custom-file">
                                                <input type="file" name="file" id="file" class="custom-file-input">
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
    // You must rewrite this code!
    let count = 0;
    let equips_input = $('#equips');
    let submit = $('#submit');
    let equips = [];
    class Equipment {
        constructor() {
            this.equipment = '';
            this.type = '';
            this.number = null;
            this.note = null;
        }
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

    function addEquipment(equips_data = new Equipment()) {
        submit.attr('disabled', false);
        ajax("{{route('district.equipment.add')}}", function(data) {
            create(data, equips_data);
        });
    }

    function create(data, equips_data) {
        equips.push(new Equipment());
        let equipments = $('#equipments');
        let row = document.createElement('div');
        let row2 = document.createElement('div');
        let col = document.createElement('div');
        let col2 = document.createElement('div');

        let equipment = document.createElement('select');
        let type = document.createElement('select');
        let number = document.createElement('input');
        let note = document.createElement('input');
        let btn = document.createElement('button');
        append(row2, equipment, 'equipment', null, "@lang('district.equipment.name')");
        append(row2, type, 'type', null,"@lang('district.equipment.type')");
        append(row2, number, 'number', 'number', "@lang('district.equipment.number')", "@lang('district.equipment.number_hint')");
        append(row2, note, 'note', 'text', "@lang('district.equipment.note')", "@lang('district.equipment.note_hint')");
        append(col2, btn, '', null, '', '', 'btn btn-danger');

        fillSelect(equipment, data, "@lang('district.equipment.name_hint')", equips_data.equipment);
        fillSelect(type, [], "@lang('district.equipment.type_hint')", equips_data.type);

        equipment.onchange = change;
        function change(use = false) {
            $(type).empty();
            equips[equipment.hint]['equipment'] = parseInt(equipment.value);
            if (!use)
                equips[equipment.hint]['type'] = '';

            ajax("{{route('district.equipment.type')}}" + `/${equipment.value}`, function(data) {
                fillSelect(type, data, "@lang('district.equipment.type_hint')", equips_data.type);
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

        /* For updating data */
        change(true);

        function append(root, element, name, type, label, placeholder, classes = 'form-control') {
            let div = document.createElement('div');
            div.classList.add('col-3');

            setProperty(element, name, type, placeholder, equips_data);
            if (label) {
                let l = document.createElement('label');
                l.textContent = label;
                l.htmlFor = name;
                div.append(l);
            }

            for (let cls of classes.split(' ')) {
                element.classList.add(cls);
            }

            if (!label) {
                div.classList.remove('col-3');
                div.classList.add('row', 'justify-content-end', 'pr-3');
            }

            div.append(element);
            root.append(div);
        }
    }

    function setProperty(element, name, type, placeholder, data = {}) {
        if (type) {
            element.type = type;
            element.value = data[name];
            element.onkeyup = function() {
                if (type === 'number') {
                    equips[element.hint][name] = parseInt(element.value);
                } else {
                    equips[element.hint][name] = element.value;
                }
                Stringify(equips);
            }
        }

        if (name) {
            element.id = name + '-' + (count + 1);
            element.name = name;
            element.placeholder = placeholder;
            element.hint = count;
            element.required = true;
            element.onchange = function() {
                equips[element.hint][name] = parseInt(element.value);
                Stringify(equips);
            }

            equips[element.hint][name] = data[name];
        } else {
            element.type = 'button';
            element.id = count + 1;
            element.innerHTML = '<i class="fas fa-minus"></i>';
            element.title = "@lang('global.btn_del')";
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

                if (count === 1) {
                    submit.attr('disabled', true);
                }
            }
        }
    }

    function fillSelect(element, data, first, value = '') {
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
            if (value === j) {
                option.selected = true;
            }
            element.append(option);
        }
    }

    function changeEquips() {
        let data = JSON.parse($('#equip_data').val());
        data.forEach(equip => {
            addEquipment(equip);
        });

        if (data.length) {
            submit.attr('disabled', false);
        }

        Stringify(data)
    }

    function Stringify(data) {
        equips_input.val(JSON.stringify(data));
    }
    // You must rewrite this code!

    $(function() {
        if ('{{$type}}' === 'accept') {
            submit.attr('disabled', true);
        }

        setTimeout(() => {
            changeEquips();
        })
    });

    $(document).ready(function() {
        $('#additional').summernote();

        $('input').each(function(){
            this.oninvalid = () => {
                this.setCustomValidity("@lang('district.recommendation.required')");
            }
            this.oninput = () => {
                this.setCustomValidity('');
            }
        });
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
