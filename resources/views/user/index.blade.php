@php
$name = 'User';
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @stop

@section('subheader-name') {{$name}} @stop

@section('subheader-link')
<span class="kt-subheader__breadcrumbs-separator"></span>
<a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}}
</a>
@stop

@section('subheader-btn')
@if (Sentinel::getUser()->hasAccess(['user.create']))
<div class="btn-group">
    <a href="{{route('user.create')}}" class="btn btn-label-brand btn-bold">Create {{$name}}</a>
</div>
@endif
@stop

@section('content')

<!--Begin::Section-->
<div class="row">
    @foreach($users as $user)
    <div class="col-md-3 col-xl-3">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head kt-portlet__head--noborder">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">

                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin::Widget -->
                <div class="kt-widget kt-widget--user-profile-2">
                    <div class="kt-widget__head">
                        <div class="kt-widget__media">
                            <div
                                class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                                {{Helper::awalan($user->name)}}
                            </div>
                        </div>

                        <div class="kt-widget__info">
                            <a href="{{route('user.show',$user->id)}}" class="kt-widget__username">
                                {{$user->name}}
                            </a>

                            <span class="kt-widget__desc">
                                {{$user->roles()->first() ? $user->roles()->first()->name :  __('user.user_role')}}
                            </span>
                        </div>
                    </div>

                    <div class="kt-widget__body">
                        <div class="kt-widget__section">
                        </div>

                        <div class="kt-widget__item">
                            <div class="kt-widget__contact">
                                <span class="kt-widget__label">Email:</span>
                                <span class="kt-widget__user">{{$user->email}}</span>
                            </div>
                            <div class="kt-widget__contact">
                                <span class="kt-widget__label">Username:</span>
                                <span class="kt-widget__user">{{$user->username}}</span>
                            </div>
                            <div class="kt-widget__contact">
                                <span class="kt-widget__label">Last Login:</span>
                                <a href="javascript::void(0)"
                                    class="kt-widget__user">{{$user->last_login ? Helper::sekianwaktu($user->last_login) :  __('User baru')}}</a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <div class="kt-widget__action">
                            <!-- <button type="button" class="btn btn-outline-brand btn-elevate btn-circle btn-icon"><i class="flaticon-bell"></i></button> -->
                            @if (Sentinel::getUser()->hasAccess(['user.show']))
                            <a href="{{route('user.show',$user->id)}}"
                                class="btn btn-icon btn-circle btn-label-twitter">
                                <i class="fa fa-eye"></i>
                            </a>
                            @endif
                            @if (Sentinel::getUser()->hasAccess(['user.update']))
                            <a href="{{route('user.update',$user->id)}}"
                                class="btn btn-icon btn-circle btn-label-twitter">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Widget -->
            </div>
        </div>
    </div>

    @endforeach

    {!! Form::open(['method'=>'DELETE', 'route' => ['user.destroy', 0], 'style' =>
    'display:none','id'=>'deleted_user_f']) !!}
    {!! Form::close() !!}
</div>
<!--End::Section-->
<div class="row">
    <div class="col-xl-12">
        <!--begin:: Components/Pagination/Default-->
        <div class="kt-portlet text-center">
            <div class="kt-portlet__body text-center">
                {{ $users->appends(Request::except('page'))->links('layouts.vendor.pagination1') }}
            </div>
        </div>
        <!--end:: Components/Pagination/Default-->
    </div>
</div>

@stop

