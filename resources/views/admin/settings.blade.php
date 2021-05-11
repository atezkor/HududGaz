@extends('voyager::master')
@section('page_title', 'getOrganizationName()')

@section('content')
    <style>
        .data-form {
            display: flex;
            justify-content: space-between;
        }

        .data-form > div {
            flex-basis: 45%;
        }

        .custom-file label::after {
            content: none;
        }

        .custom-file label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: transparent;
            padding-right: 0;
        }
    </style>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('voyager::alerts')
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{__('table.general_settings.settings_title')}}</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="card-body">
                                <div class="data-form">
                                    <div class="form-group">
                                        <label for="shareholder_name">{{__('table.general_settings.shareholder_name')}}</label>
                                        <input type="text" name="shareholder_name" id="shareholder_name" class="form-control"
                                               value="{{$data['shareholder_name'] ?? ''}}"
                                               placeholder="{{__('table.general_settings.shareholder_name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="branch_name">{{__('table.general_settings.branch_name')}}</label>
                                        <input type="text" name="branch_name" id="branch_name" class="form-control"
                                               value="{{$data['branch_name'] ?? ''}}"
                                               placeholder="{{__('table.general_settings.branch_name')}}">
                                    </div>
                                </div>

                                <div class="data-form">
                                    <div class="form-group">
                                        <label for="engineer">{{__('table.general_settings.engineer')}}</label>
                                        <input type="text" name="engineer_name" id="engineer_name" class="form-control"
                                               value="{{$data['engineer_name'] ?? ''}}"
                                               placeholder="{{__('table.general_settings.full_name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{__('table.general_settings.helper')}}</label>
                                        <input type="text" name="helper_name" id="helper_name" class="form-control"
                                               value="{{$data['helper_name'] ?? ''}}"
                                               placeholder="{{__('table.general_settings.full_name')}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">{{__('table.designers.phone_number')}}</label>
                                    <textarea type="tel" name="phone_number" id="phone_number" class="form-control">{{$data['phone_number'] ?? ''}}</textarea>
                                </div>
                                <hr><br>
                                <div class="form-group row">
                                    <label for="reg_num" class="col-sm-2 col-form-label">{{__('table.regions.org_number')}}</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="reg_num" id="reg_num" class="form-control"
                                               value="{{$data['reg_num'] ?? ''}}"
                                               placeholder="0000">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address_latin" class="col-sm-2 col-form-label">{{__('table.regions.address_latin')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="address_latin" id="address_latin" class="form-control"
                                               value="{{$data['address_latin'] ?? ''}}"
                                               placeholder="{{__('table.regions.address_latin')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">{{__('table.regions.address')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="address" id="address" class="form-control"
                                               value="{{$data['address'] ?? ''}}"
                                               placeholder="{{__('table.regions.address')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_address" class="col-sm-2 col-form-label">{{__('table.regions.email')}}</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email_address" id="email_address" class="form-control"
                                               value="{{$data['email_address'] ?? ''}}"
                                               placeholder="{{__('table.regions.email')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fax" class="col-sm-2 col-form-label">{{__('table.regions.fax')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="fax" id="fax" class="form-control"
                                               value="{{$data['fax'] ?? ''}}"
                                               placeholder="{{__('table.regions.fax')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div id="preview_img" class="col-sm-2 col-form-label">

                                    </div>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" name="logo" id="logo" class="custom-file-input">
                                            <label class="custom-file-label" for="logo">
                                                <span id="path_label">{{__('table.general_settings.upload_image')}}</span>
{{--                                                <div class="btn btn-info"><i class="far fa-file-image"></i></div>--}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">{{__('table.general_settings.button_save_data')}}</button>
                                <a href="{{route('admin.general_settings.index')}}" class="btn btn-outline-secondary">{{__('table.general_settings.button_cancel')}}</a>
                                <button type="reset" id="reset_button" class="btn btn-default float-right">{{__('table.general_settings.button_clear')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('body_js')
    <script>
        $('#logo').change(function(input) {
            try {
                $('#path_label').text(input.target.files[0].name);
                let reader = new FileReader();
                reader.readAsDataURL(input.target.files[0]);
                reader.onload = function () {
                    $("#preview_img").html(`<img src="${reader.result}" class="img-thumbnail" alt="rasm">`);

                    setTimeout(() => {
                        $('.custom-file').css({
                            marginTop: ($("#preview_img").height() / 2.5)
                        });
                    }, 1)
                }
            } catch (e) {}
        });

        {{--$('#reset_button').click(function () {--}}
        {{--    $('.custom-file').css({--}}
        {{--        marginTop: 0--}}
        {{--    });--}}
        {{--    $("#preview_img").html('');--}}

        {{--    $('#path_label').text('{{__('table.general_settings.upload_image')}}');--}}
        {{--});--}}
    </script>
@endsection
