
@php
  $name = 'Inventory';
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @lang('global.app_detail') @stop

@section('subheader-name') {{$name}} @lang('global.app_detail') @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript:void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}} @lang('global.app_detail')
  </a>
@stop

@section('subheader-btn')
  @if(Sentinel::getUser()->hasAccess(['inventory.index']))
  <a href="{{route('inventory.index')}}" class="btn btn-default btn-bold">
    @lang('global.app_back_to_list')
  </a>
  @endif
  @if(Sentinel::getUser()->hasAccess(['inventory.update']))
  <a href="javascript:void(0)" onclick="editinventory({{$inventory->id.','.$inventory->product_id.','.$inventory->unit_id}})" class="btn btn-success btn-bold">
    @lang('global.app_edit')
  </a>
  @endif
  @if(Sentinel::getUser()->hasAccess(['inventory.destroy']))
  <a href="javascript:void(0)" onclick="confirmdelete({{$inventory->id}})" class="btn btn-danger btn-bold">
    @lang('global.app_delete')
  </a>
  @endif
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__body">
    <!--begin: inventorytable -->
    <table class="table table-striped table-checkable" id="tbl_inventory">
    <thead>
        <tr>
          <th>Product</th>
          <th>: {{$inventory->product->name}}</th>
          <th>Stock</th>
          <th>: {{$inventory->details->sum('total')-$inventory->out->sum('total')}}</th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th>Unit</th>
          <th>: {{$inventory->unit->name}}</th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
    </table>
    <!--end: inventorytable -->
  </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <span class="kt-portlet__head-icon">
        <i class="kt-font-brand flaticon2-line-chart"></i>
      </span>
      <h3 class="kt-portlet__head-title">
        @lang('global.app_list') {{$name}} Masuk
      </h3>
    </div>
    <div class="kt-portlet__head-toolbar">
    </div>
  </div>

  <div class="kt-portlet__body">
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inventoryDetailMasuk">
    <thead>
        <tr>
          <th>Date</th>
          <th>Supplier</th>
          <th>Total</th>
          <th>In Charge</th>
          @if(Sentinel::getUser()->hasAccess(['inventoryDetail.update']) || Sentinel::getUser()->hasAccess(['inventoryDetail.destroy']))
          <th>@lang('global.app_action')</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($inventory->details as $detail)
          <tr>
            <td>{{$detail->date}}</td>
            <td>
                  {{$detail->supplier->name}}
            </td>
            <td>{{$detail->total}}</td>
            <td>{{$detail->user->name}}</td>
            <td>
            @if (Sentinel::getUser()->roles[0]->slug == "admin")
            @if(Sentinel::getUser()->hasAccess(['inventoryDetail.update']) || Sentinel::getUser()->hasAccess(['inventoryDetail.destroy']))
              
                @if(Sentinel::getUser()->hasAccess(['inventoryDetail.update']))
                <a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="editmodal({{$detail}})">@lang('global.app_edit')</a>
                @endif
                @if(Sentinel::getUser()->hasAccess(['inventoryDetail.destroy']))
                <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmdeletedetail({{$detail->id}})">@lang('global.app_delete')</a>
                @endif
            @endif
            @else
            @if(Sentinel::getUser()->id == $detail->user_id)
                @if(Sentinel::getUser()->hasAccess(['inventoryDetail.update']))
                <a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="editmodal({{$detail}})">@lang('global.app_edit')</a>
                @endif
                @if(Sentinel::getUser()->hasAccess(['inventoryDetail.destroy']))
                <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmdeletedetail({{$detail->id}})">@lang('global.app_delete')</a>
                @endif
            @endif
            @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <span class="kt-portlet__head-icon">
        <i class="kt-font-brand flaticon2-line-chart"></i>
      </span>
      <h3 class="kt-portlet__head-title">
        @lang('global.app_list') {{$name}} out
      </h3>
    </div>
    <div class="kt-portlet__head-toolbar">

    </div>
  </div>

  <div class="kt-portlet__body">
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inventoryDetailout">
      <thead>
        <tr>
          <th>Date</th>
          <th>Note</th>
          <th>Total</th>
          <th>In Charge</th>
          @if(Sentinel::getUser()->hasAccess(['inventoryDetail.updt']) || Sentinel::getUser()->hasAccess(['inventoryDetail.destroy']))
          <th>@lang('global.app_action')</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($inventory->out as $out)
          <tr>
            <td>{{$out->date}}</td>
            <td>{{$out->note}}</td>
            <td>{{$out->total}}</td>
            <td>{{$out->user->name}}</td>
            <td>
            @if (Sentinel::getUser()->roles[0]->slug == "admin")
            @if(Sentinel::getUser()->hasAccess(['outInventory.update']) || Sentinel::getUser()->hasAccess(['outInventory.destroy']))
                @if(Sentinel::getUser()->hasAccess(['outInventory.update']))
                <a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="editmodalout({{$out}})">@lang('global.app_edit')</a>
                @endif
                @if(Sentinel::getUser()->hasAccess(['outInventory.destroy']))
                <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmdeleteout({{$out->id}})">@lang('global.app_delete')</a>
                @endif
                @endif
                @else
                @if(Sentinel::getUser()->id == $detail->user_id)
                  @if(Sentinel::getUser()->hasAccess(['outInventory.update']))
                  <a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="editmodalout({{$out}})">@lang('global.app_edit')</a>
                  @endif
                  @if(Sentinel::getUser()->hasAccess(['outInventory.destroy']))
                  <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmdeleteout({{$out->id}})">@lang('global.app_delete')</a>
                  @endif
                @endif
                @endif
                
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="f_modal_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('url' => route('inventoryDetail.store',$inventory->id), 'files' => true, 'id'=>'form_inventoryDetail_create')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Date:</label>
              </div>
              <div class="kt-form__control">
                <input type="date" name="date" class="form-control" placeholder="Enter number" id="d_date_create">
                @error('total')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Supplier:</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('supplier', $supplier, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_supplier_create']) !!}
                @error('supplier')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
              <div class="kt-form__control kt-margin-t-10" id="field_supplier_lainnya_create">
                <input type="text" name="supplier_lain" class="form-control" placeholder="Enter supplier Lainnya" id="i_supplier_lainnya_create">
                @error('supplier_lain')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">Total:</label>
                </div>
                <div class="kt-form__control">
                  <input type="number" min="1" name="total" class="form-control" placeholder="Enter number" id="n_total_create">
                  @error('total')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="f_modal_create_out" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('url' => route('outInventory.store',$inventory->id), 'files' => true, 'id'=>'form_outInventory_create')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Date:</label>
              </div>
              <div class="kt-form__control">
                <input type="date" name="date" class="form-control" placeholder="Enter number" id="d_date_create">
                @error('date')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">Total:</label>
                </div>
                <div class="kt-form__control">
                  <input type="number" min="1" name="total" class="form-control" placeholder="Enter number" id="n_total_create">
                  @error('total')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
            <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">Note:</label>
                </div>
                <div class="kt-form__control">
                  <textarea  name="note" class="form-control" id="k_note_create">
                  </textarea>
                  @error('note')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH','url' => '#', 'files' => true, 'id'=>'form_inventoryDetail_edit')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Date:</label>
              </div>
              <div class="kt-form__control">
                <input type="date" name="date" class="form-control" placeholder="Enter number" id="d_date_update">
                @error('date')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Supplier:</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('supplier', $supplier, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_supplier_update']) !!}
                @error('supplier')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
              <div class="kt-form__control kt-margin-t-10" id="field_supplier_lainnya_update">
                <input type="text" name="supplier_lain" class="form-control" placeholder="Enter supplier Lainnya" id="i_supplier_lainnya_update">
                @error('supplier_lain')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">Total</label>
                </div>
                <div class="kt-form__control">
                  <input type="number" min="1" name="total" class="form-control" placeholder="Enter number" id="n_total_update">
                  @error('total')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit_out" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
        <button type="button" class="close" inventory-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH','url' => '#', 'files' => true, 'id'=>'form_outInventory_edit')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Date:</label>
              </div>
              <div class="kt-form__control">
                <input type="date" name="date" class="form-control" placeholder="Enter number" id="d_date_update_out">
                @error('date')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">Total:</label>
                </div>
                <div class="kt-form__control">
                <input type="number" min="1" max="{{$inventory->details->sum('total')-$inventory->out()->sum('total')}}" name="total" class="form-control" placeholder="Enter number" id="n_total_update_out">
                  @error('total')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
            <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">Note:</label>
                </div>
                <div class="kt-form__control">
                  <textarea  name="note" class="form-control" id="k_note_update_out">
                  </textarea>
                  @error('note')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" inventory-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit_inventory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" inventory-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH', 'url' => '#', 'files' => true, 'id'=>'form_edit_inventory')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventoryRequest.field.product'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('product', $product, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_product_update_inventory']) !!}
                @error('product')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventoryRequest.field.unit'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('unit', $unit, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_unit_update_inventory']) !!}
                @error('unit')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" inventory-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

{!! Form::open(['method'=>'DELETE', 'route' => ['inventory.destroy', 0], 'style' => 'display:none','id'=>'deleted_f']) !!}
{!! Form::close() !!}
@stop

@section('tcss')
<link href="{{asset('theme/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('tjs')
  <script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    $('#field_supplier_lainnya_create').hide();
    $('#field_supplier_lainnya_update').hide();
    jQuery(document).ready(function() {
      var table = $('#tbl_inventoryDetailMasuk').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        buttons: [
            {
                text: "Add inventory",
                className: "btn btn-outline-primary",
                action: function ( e, dt, node, config ) {
                    openmodalcreate();
                }
            }
        ]
      });

      var table = $('#tbl_inventoryDetailout').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        @if(Sentinel::getUser()->hasAccess(['outInventory.store']))
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        buttons: [
            {
                text: "Out Inventory",
                className: "btn btn-outline-primary",
                action: function ( e, dt, node, config ) {
                    openmodalcreateout();
                }
            }
        ]
        @endif
      });
    });

    $('#f_modal_create').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
            allowClear: true
        });
        $('.myselect2').val(0).change();
    });

    $('#f_modal_create .myselect2').on('select2:select', function (e) {
        var id = $('#s_supplier_create').val();
        if(id=="xxx"){
          $('#field_supplier_lainnya_create').show();
        }else{
          $('#field_supplier_lainnya_create').hide();
        }
    });

    $('#f_modal_edit .myselect2').on('select2:select', function (e) {
         var id = $('#s_supplier_update').val();
        if(id=="xxx"){
          $('#field_supplier_lainnya_update').show();
        }else{
          $('#field_supplier_lainnya_update').hide();
        }
    });

    $('#f_modal_create_out').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
        $('.myselect2').val(0).change();
    });

    $('#f_modal_edit_inventory').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
    });

    $('#f_modal_edit').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
    });

    function openmodalcreate() {
      emptyform();
      $('#f_modal_create').modal('show');
    }

    function openmodalcreateout() {
      emptyform();
      $('#f_modal_create_out').modal('show');
    }

    function editmodal(detail) {
      emptyform();
      $("#s_supplier_update").val(detail.supplier_id).trigger('change');
      $("#n_total_update").val(detail.total);
      $("#d_date_update").val(detail.date);
      $('#f_modal_edit').modal('show');
      var base = "{{url('/')}}";
      $('#form_inventoryDetail_edit').attr('action', base+"/inventoryDetail/{{$inventory->id}}/"+detail.id);
    }

    function editmodalout(out) {
      emptyform();
      $("#d_date_update_out").val(out.date);
      $("#n_total_update_out").val(out.total);
      $("#k_note_update_out").val(out.note).trigger('change');
      $('#f_modal_edit_out').modal('show');
      var base = "{{url('/')}}";
      $('#form_outInventory_edit').attr('action', base+"/outInventory/{{$inventory->id}}/"+out.id);
    }

    function emptyform() {
      //form create inventory masuk
      $('#field_supplier_lainnya_create').hide();
      $('#i_supplier_lainnya_create').val('');
      $("#s_supplier_create").val(0).trigger('change');
      $("#d_date_create").val('');
      $("#n_total_create").val(0);

      //form update inventory masuk
      $('#field_supplier_lainnya_update').hide();
      $('#i_supplier_lainnya_update').val('');
      $("#d_date_update").val('');
      $("#s_supplier_update").val(0).trigger('change');
      $("#n_total_update").val(0);

      //form create inventory out
      $("#k_note_create").val('');

      //form update inventory out
      $("#k_note_update").val('');
      $("#d_date_update_out").val('');
      $("#n_total_update_out").val(0);
    }

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
              $('#deleted_f').attr('action', "{{route('inventory.index')}}/"+id);
              $('#deleted_f').submit();
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

    function confirmdeletedetail(id) {
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
              var base = "{{url('/')}}";
              $('#deleted_f').attr('action', base+"/inventoryDetail/{{$inventory->id}}/"+id);
              $('#deleted_f').submit();
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

    function confirmdeleteout(id) {
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
              var base = "{{url('/')}}";
              $('#deleted_f').attr('action', base+"/outInventory/{{$inventory->id}}/"+id);
              $('#deleted_f').submit();
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

    function editinventory(id, product, unit) {
      $("#s_product_update_inventory").val(product).trigger('change');
      $("#s_unit_update_inventory").val(unit).trigger('change');
      $('#f_modal_edit_inventory').modal('show');
      var base = "{{url('/')}}";
      $('#form_edit_inventory').attr('action', base+'/inventory/'+id);
    }
  </script>
@endsection
