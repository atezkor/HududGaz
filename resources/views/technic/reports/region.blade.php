@extends('layout')
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped table-center">
                                <thead>
                                    <tr>
                                        <th>@lang('global.index')</th>
                                        <th>@lang('technic.district')</th>
                                        <th>@lang('technic.total')</th>
                                        @foreach($activities as $activity)
                                        <th>{{$activity}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $key => $model)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$model->district}}</td>
                                    @if(isset($propositions[$key + 1]))
                                        <td>{{$propositions[$key + 1]->count()}}</td>
                                    @php
                                    if (isset($propositions))
                                        if (isset($key))
                                            $proposition = $propositions[$key + 1]->groupBy('activity_type')
                                    @endphp
                                @foreach($activities as $id => $activity)
                                    @if(isset($proposition[$id]))
                                        <td>{{$proposition[$id]->count()}}</td>
                                    @else
                                        <td>0</td>
                                    @endif
                                @endforeach
                                    @else
                                        <td>0</td> {{-- This is for total count --}}
                                    @for($i = 0; $i < $activities->count(); $i ++)
                                        <td>0</td>
                                    @endfor
                                    @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
