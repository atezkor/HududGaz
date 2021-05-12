@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/default.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{__('table.organization.title')}}</h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            <div class="data-form">
                                <div class="form-group">
                                    <label for="shareholder_name">{{__('table.organization.shareholder_name')}}</label>
                                    <input type="text" name="shareholder_name" id="shareholder_name" class="form-control"
                                           value="{{$data['shareholder_name'] ?? ''}}"
                                           placeholder="{{__('table.organization.shareholder_name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="branch_name">{{__('table.organization.branch_name')}}</label>
                                    <input type="text" name="branch_name" id="branch_name" class="form-control"
                                           value="{{$data['branch_name'] ?? ''}}"
                                           placeholder="{{__('table.organization.branch_name')}}">
                                </div>
                            </div>

                            <div class="data-form">
                                <div class="form-group">
                                    <label for="engineer">{{__('table.organization.engineer')}}</label>
                                    <input type="text" name="engineer_name" id="engineer_name" class="form-control"
                                           value="{{$data['engineer_name'] ?? ''}}"
                                           placeholder="{{__('table.organization.full_name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('table.organization.helper')}}</label>
                                    <input type="text" name="helper_name" id="helper_name" class="form-control"
                                           value="{{$data['helper_name'] ?? ''}}"
                                           placeholder="{{__('table.organization.full_name')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">{{__('table.organization.phone')}}</label>
                                <textarea type="tel" name="phone" id="phone" class="form-control">{{$data['phone'] ?? ''}}</textarea>
                            </div>
                            <hr><br>
                            <div class="form-group row">
                                <label for="reg_num" class="col-sm-2 col-form-label">{{__('table.organization.org_num')}}</label>
                                <div class="col-sm-10">
                                    <input type="number" name="reg_num" id="reg_num" class="form-control"
                                           value="{{$data['reg_num'] ?? ''}}"
                                           placeholder="0000">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address_latin" class="col-sm-2 col-form-label">{{__('table.organization.address_latin')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address_latin" id="address_latin" class="form-control"
                                           value="{{$data['address_latin'] ?? ''}}"
                                           placeholder="{{__('table.organization.address_latin')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label">{{__('table.organization.address')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" id="address" class="form-control"
                                           value="{{$data['address'] ?? ''}}"
                                           placeholder="{{__('table.organization.address')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">{{__('table.organization.email')}}</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{$data['email'] ?? ''}}"
                                           placeholder="{{__('table.organization.email')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fax" class="col-sm-2 col-form-label">{{__('table.organization.fax')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fax" id="fax" class="form-control"
                                           value="{{$data['fax'] ?? ''}}"
                                           placeholder="{{__('table.organization.fax')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div id="preview" class="col-sm-2 col-form-label">

                                </div>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" name="logo" id="logo" accept=".jpg, .png, .svg" class="custom-file-input">
                                        <label class="custom-file-label" for="logo">
                                            <span id="path_label">{{__('table.organization.upload_image')}}</span>
                                                <span class="btn btn-info"><i class="far fa-file-image"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{__('table.btn_save')}}</button>
                            <a href="{{route('admin.settings')}}" class="btn btn-outline-secondary">{{__('table.btn_cancel')}}</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">{{__('table.btn_reset')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
    <script>
        $('#logo').change(function(input) {
            try {
                $('#path_label').text(input.target.files[0].name);
                let reader = new FileReader();
                reader.readAsDataURL(input.target.files[0]);
                reader.onload = function () {
                    $("#preview").html(`<img src="${reader.result}" class="img-thumbnail" alt="img">`);

                    setTimeout(() => {
                        $('.custom-file').css({
                            marginTop: ($("#preview").height() / 2.5)
                        });
                    }, 1)
                }
            } catch (e) {}
        });

        $('#reset').on('click', function () {
            $('.custom-file').css({
                marginTop: 0
            });
            $("#preview").html('');

            $('#path_label').text('{{__('table.organization.upload_image')}}');
        });
    </script>
@endsection
