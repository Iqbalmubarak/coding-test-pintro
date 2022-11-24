
@php
  $name = __('inventory.title');
  $status = 'available';
  if(isset($_GET['status'])){
    $status = $_GET['status'];
  }
@endphp
@extends('layouts.L1')

@section('title')@lang('global.app_create') {{$name}} @stop

@section('subheader-name')@lang('global.app_create') {{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    @lang('global.app_create') {{$name}}
  </a>
@stop

@section('subheader-btn')
<a href="{{route('inventory.index')}}?status={{$status}}" class="btn btn-default btn-bold">
  @lang('global.app_back_to_list')
</a>
<div class="btn-group">
  <button type="button" class="btn btn-brand btn-bold" onclick="$('#user_create_f').click()">
    @lang('global.app_save')
  </button>
</div>
@stop

@section('content')
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
      {{ Form::open(array('url' => route('inventory.store'), 'files' => true)) }}
        <div class="tab-content">
          <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form kt-form--label-right">
              <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Product Name</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::select('product', $product,null, ['class' => 'form-control kt-select2 myselect2','required'=>'required','id'=>'s_product_create']) !!}
                        @error('product')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Unit Name</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::select('unit', $unit,null, ['class' => 'form-control kt-select2 myselect2','required'=>'required','id'=>'s_unit_create']) !!}
                        @error('unit')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Supplier Name</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::select('supplier', $supplier,null, ['class' => 'form-control kt-select2 myselect2','required'=>'required','id'=>'s_supplier_create']) !!}
                        @error('supplier')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row" id="field_supplier_lainnya_create">
                      <div class="col-xl-3 col-lg-3 col-form-label"></div>
                      <div class="col-lg-9 col-xl-6">
                        <input type="text" name="supplier_lain" class="form-control" placeholder="Enter supplier Lainnya" id="i_supplier_lainnya_create">
                        @error('supplier_lain')
                        <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Date</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::date('date', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
                        @error('date')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Total</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::number('total', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required','min'=>1]) !!}
                        @error('total')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" name="button" id="user_create_f">
                    @lang('global.app_save')
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop

@section('tjs')
  <script type="text/javascript">
    $('#field_supplier_lainnya_create').hide();
    $(".myselect2").select2({
        placeholder: "Select a state",
        allowClear: true
    });
    $('.myselect2').val(0).change();

    $('#s_supplier_create').on('select2:select', function (e) {
        var id = e.params.data.id;
        if(id=={{count($supplier)}}){
          $('#field_supplier_lainnya_create').show();
        }else{
          $('#field_supplier_lainnya_create').hide();
        }
    });

  </script>
@endsection
