@extends('layouts.app')
@section('title')
@endsection
@section('css')
@endsection
@section('content')

    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Kalem</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a>
                </li>
                <li class="breadcrumb-item active">Kalem</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Yeni Kalem Ekle</a>
            </div>
        </div>
        <!-- /.page-title-right -->
    </div>

    @if(session('status'))
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="alert alert-success">{{ session('status') }}</div>
            </div>
        </div>
    @endif
    <!-- /.page-title -->
    <!-- =================================== -->
    <!-- Different data widgets ============ -->
    <!-- =================================== -->
    <div class="widget-list">
        <div class="row">
            <div class="col-md-12 widget-holder">
                <div class="widget-bg">
                    <div class="widget-body clearfix">
                        <form action="{{route('kalem.store')}}" method="POST">
                            @csrf



                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="" class="col-form-label">Kalem Tipi</label>
                                    <div>
                                        <input type="radio" class="mr-1 change-customer-type" name="kalemTipi" id="" checked value="0">Gelir
                                    </div>
                                    <div>
                                        <input type="radio" class="mr-1 change-customer-type" name="kalemTipi" id="" value="1">Gider
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row firma-area">
                                <div class="col-md-6">
                                    <label class=" col-form-label" for="l0">Kalem Adı</label>
                                    <input class="form-control"  required name="ad"  type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class=" col-form-label" for="l0">KDV</label>
                                    <input class="form-control"  name="kdv" value="18"  type="text">
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="form-group row">
                                    <div class="col-md-12 ml-md-auto btn-list">
                                        <button class="btn btn-primary btn-rounded" type="submit">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.widget-body -->
                </div>
                <!-- /.widget-bg -->
            </div>
            <!-- /.widget-holder -->
        </div>
        <!-- /.row -->
    </div>

@endsection
