<div class="kt-section__body">
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>__('user.field.name')]) !!}
      @error('name')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>__('user.field.username'),'required'=>'required']) !!}
      @error('username')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>

@section('tjs')
  <script src="{{asset('theme/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
  <script src="{{asset('theme/js/pages/crud/forms/widgets/select2.js')}}" type="text/javascript"></script>
@endsection

@section('tcss')
  <link href="{{asset('theme/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
@endsection
