@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{__('admin.organization.title')}}</h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6 pr-5">
                                    <label for="shareholder_name">{{__('admin.organization.shareholder_name')}}</label>
                                    <input type="text" name="shareholder_name" id="shareholder_name" class="form-control"
                                           value="{{$model->shareholder_name}}"
                                           placeholder="{{__('admin.organization.shareholder_name')}}">
                                </div>
                                <div class="form-group col-6 pl-5">
                                    <label for="branch_name">{{__('admin.organization.branch_name')}}</label>
                                    <input type="text" name="branch_name" id="branch_name" class="form-control"
                                           value="{{$model->branch_name}}"
                                           placeholder="{{__('admin.organization.branch_name')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6 pr-5">
                                    <label for="engineer">{{__('admin.organization.engineer')}}</label>
                                    <input type="text" name="engineer" id="engineer" class="form-control"
                                           value="{{$model->engineer}}"
                                           placeholder="{{__('admin.organization.full_name')}}">
                                </div>
                                <div class="form-group col-6 pl-5">
                                    <label for="helper_engineer">{{__('admin.organization.helper_name')}}</label>
                                    <input type="text" name="helper_engineer" id="helper_engineer" class="form-control"
                                           value="{{$model->helper_engineer}}"
                                           placeholder="{{__('admin.organization.full_name')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6 pr-5">
                                    <label for="tech_section">{{__('admin.organization.tech_section')}}</label>
                                    <input type="text" name="tech_section" id="tech_section" class="form-control"
                                           value="{{$model->tech_section}}"
                                           placeholder="{{__('admin.organization.full_name')}}">
                                </div>
                                <div class="form-group col-6 pl-5">
                                    <label for="legal_section">{{__('admin.organization.legal_section')}}</label>
                                    <input type="text" name="legal_section" id="legal_section" class="form-control"
                                           value="{{$model->legal_section}}"
                                           placeholder="{{__('admin.organization.full_name')}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 pr-5">
                                    <label for="met_section">{{__('admin.organization.met_section')}}</label>
                                    <input type="text" name="met_section" id="met_section" class="form-control"
                                           value="{{$model->met_section}}"
                                           placeholder="{{__('admin.organization.full_name')}}">
                                </div>
                                <div class="form-group col-6 pl-5">
                                    <label for="exploitation_section">{{__('admin.organization.exploitation_section')}}</label>
                                    <input type="text" name="exploitation_section" id="exploitation_section" class="form-control"
                                           value="{{$model->exploitation_section}}"
                                           placeholder="{{__('admin.organization.full_name')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">{{__('admin.organization.phone')}}</label>
                                <textarea type="tel" name="phone" id="phone" class="form-control">{{$model->phone}}</textarea>
                            </div>
                            <hr><br>
                            <div class="form-group row">
                                <label for="reg_num" class="col-sm-2 col-form-label">{{__('admin.organization.org_num')}}</label>
                                <div class="col-sm-10">
                                    <input type="number" name="reg_num" id="reg_num" class="form-control"
                                           value="{{$model->reg_num}}"
                                           placeholder="0000">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address_latin" class="col-sm-2 col-form-label">{{__('admin.organization.address_latin')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address_latin" id="address_latin" class="form-control"
                                           value="{{$model->address_latin}}"
                                           placeholder="{{__('admin.organization.address_latin')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label">{{__('admin.organization.address')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" id="address" class="form-control"
                                           value="{{$model->address}}"
                                           placeholder="{{__('admin.organization.address')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.organization.email')}}</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{$model->email}}"
                                           placeholder="{{__('admin.organization.email')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fax" class="col-sm-2 col-form-label">{{__('admin.fax')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fax" id="fax" class="form-control"
                                           value="{{$model->fax}}"
                                           placeholder="{{__('admin.fax')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div id="preview" class="col-sm-2 col-form-label">
                                </div>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" name="logo" id="logo" accept=".jpg, .png, .svg" class="custom-file-input">
                                        <label class="custom-file-label" for="logo">
                                            <span id="file_hint">{{__('admin.organization.upload_image')}}</span>
                                                <span class="btn btn-info"><i class="far fa-file-image"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{__('global.btn_save')}}</button>
                            <a href="{{route('admin.settings')}}" class="btn btn-outline-secondary">{{__('global.btn_cancel')}}</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">{{__('global.btn_reset')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{'/js/typographer.js'}}"></script>
<script>
    $('#logo').change(function(input) {
        try {
            $('#file_hint').text(input.target.files[0].name);
            let reader = new FileReader();
            reader.readAsDataURL(input.target.files[0]);
            reader.onload = function() {
                $("#preview").html(`<img src="${reader.result}" class="img-thumbnail" alt="img">`);

                setTimeout(() => {
                    $('.custom-file').css({
                        marginTop: ($("#preview").height() / 2.5)
                    });
                }, 1);
            }
        } catch (e) {}
    });

    $('#reset').on('click', function() {
        $('.custom-file').css({
            marginTop: 0
        });
        $("#preview").html('');

        $('#file_hint').text('{{__('admin.organization.upload_image')}}');
    });

    $('input').each((i, input) => {
        typographer(input);
        input.oninput = function() {
            typographer(input);
        }
    })
</script>
@endsection
