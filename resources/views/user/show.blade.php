
@php
  $name = 'User';
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @lang('global.app_detail') @stop

@section('subheader-name') {{$name}} @lang('global.app_detail') @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}} @lang('global.app_detail')
  </a>
@stop

@section('subheader-btn')
@if(Sentinel::getUser()->hasAccess(['user.index']))
<a href="{{route('user.index')}}" class="btn btn-default btn-bold">
  @lang('global.app_back_to_list')
</a>
@endif
<div class="btn-group">
  @if(Sentinel::getUser()->hasAccess(['user.edit']))
  <a href="{{route('user.edit',$data->id)}}" class="btn btn-success btn-bold">
    @lang('global.app_edit')
  </a>
  @endif
</div>
@stop

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!--Begin::Section-->
  <div class="row justify-content-md-center justify-content-xl-center">
    <div class="kt-section__body">
      <div class="kt-portlet kt-portlet--tabs">
          <div class="kt-portlet__body">
            <div class="tab-content">
              <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                <div class="kt-form kt-form--label-right">
                  <div class="kt-form__body">
                    <div class="kt-section kt-section--first">
                      <div class="form-group text-center">
                        <a href="#" class="kt-media  kt-media--xl kt-media--success">
                          <span>{{Helper::awalan($data->name)}}</span>
                        </a>
                      </div>

                      <div class="form-group row">
                        {!! Form::text('name', $data->name, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('username', $data->username, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('last_login', $data->last_login ? Helper::sekianwaktu($data->last_login) :  __('user.user_new'), ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <!--End::Section-->
  {!! Form::open(['method'=>'DELETE', 'route' => ['user.destroy', 0], 'style' => 'display:none','id'=>'deleted_user_f']) !!}
  {!! Form::close() !!}
</div>
@stop

@section('tcss')
  <link href="{{asset('theme/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('tjs')
  <script src="{{asset('theme/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
  <script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
  function confirmdelete(id) {
    swal.fire({
        title: "@lang('global.app_delete_ask')",
        text: "@lang('global.app_deleted_description')",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "@lang('global.app_delete_confirm')",
        cancelButtonText: "@lang('global.app_delete_cancel')",
        reverseButtons: true
    }).then(function(result){
        if (result.value) {
            swal.fire(
                "@lang('global.app_deleted_confirm_massage_1')",
                "@lang('global.app_deleted_confirm_massage_2')",
                'success'
            )
            $('#deleted_user_f').attr('action', "{{route('user.index')}}/"+id);
            $('#deleted_user_f').submit();
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                "@lang('global.app_deleted_cancel_massage_1')",
                "@lang('global.app_deleted_cancel_massage_2')",
                'error'
            )
            event.preventDefault();
        }
    });
  }

  function confirmaktivasi(link) {
    event.preventDefault();
    swal.fire({
        title: "@lang('user.user_actived_ask')",
        text: "@lang('user.user_actived_description')",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "@lang('user.user_actived_confirm')",
        cancelButtonText: "@lang('user.user_actived_cancel')",
        reverseButtons: true
    }).then(
      function(result){
        if (result.value) {
            swal.fire(
                "@lang('user.user_actived_confirm_massage_1')",
                "@lang('user.user_actived_confirm_massage_2')",
                'success'
            )
            window.open(link,"_self");
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                "@lang('global.app_delete_cancel')",
                "@lang('user.user_actived_cancel_massage_2')",
                'warning'
            )
        }
    });
  }

  function confirmdeaktivasi(link) {
    event.preventDefault();
    swal.fire({
        title: "@lang('user.user_deactived_ask')",
        text: "@lang('user.user_deactived_description')",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "@lang('user.user_deactived_confirm')",
        cancelButtonText: "@lang('user.user_deactived_cancel')",
        reverseButtons: true
    }).then(
      function(result){
        if (result.value) {
            swal.fire(
                "@lang('user.user_deactived_confirm_massage_1')",
                "@lang('user.user_deactived_confirm_massage_2')",
                'success'
            )
            window.open(link,"_self");
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                "@lang('global.app_delete_cancel')",
                "@lang('user.user_deactived_cancel_massage_2')",
                'warning'
            )
        }
    });
  }
  </script>
@endsection
