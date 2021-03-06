@extends('user.layouts')

@section('css')
    <link href="/assets/pages/css/pricing.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <style>
        .fancybox > img {
            width: 75px;
            height: 75px;
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <!-- BEGIN PAGE BASE CONTENT -->

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-link font-blue"></i>
                            <span class="caption-subject font-blue bold">购买必读</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="mt-clipboard-container">
                            流量可购买多次，每次购买会叠加流量；<br>
                            套餐购买会导致之前购买的套餐失效，请谨慎购买！<br>
                            购买任一服务后，凭账单号码加QQ群：674788156 获得后续增值服务或报告异常。<br>
                            <b style="font-size: 1.2em;color: red;">如果您遇到任何问题，<b><a href="{{url('user/ticketList')}}">点我发起服务单，</a></b>我们会第一时间处理您的请求。</b><br>
                            <b style="font-size: 1.2em;color: brown;">您的任何消费，将会给您的推介人带来您消费金额{{$app_config['referral_percent']*100}}%的收益；</b><br>
                            <b style="font-size: 1.2em;color: brown;">同样的，您的推介也会给您带来可提现的收益。<a href="{{url('home/aff')}}">了解推介计划</a></b><br>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light table-checkable order-column">
                                <thead>
                                <tr>
                                    <th style="width:35%;"> {{trans('home.service_name')}} </th>
                                    <th style="text-align: center;"> {{trans('home.service_desc')}} </th>
                                    <th style="text-align: center;"> {{trans('home.service_type')}} </th>
                                    <th style="text-align: center;"> {{trans('home.service_price')}} </th>
                                    <th> </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($goodsList->isEmpty())
                                    <tr>
                                        <td colspan="5" style="text-align: center;">{{trans('home.services_none')}}</td>
                                    </tr>
                                @else
                                    @foreach($goodsList as $key => $goods)
                                        <tr class="odd gradeX">
                                            <td style="width: 20%;">
                                                <!--@if($goods->logo) <a href="{{$goods->logo}}" class="fancybox"><img src="{{$goods->logo}}"/></a> @endif -->
                                                <span style="font-size: 1.15em; color: #000;">{{$goods->name}}</span>
                                                <br>
                                                <span style="color: #000;">{{trans('home.service_traffic')}}：{{$goods->traffic}}</span>
                                                <br>
                                                <span style="color: #000;">{{trans('home.service_days')}}：{{$goods->days}} {{trans('home.day')}}</span>
                                            </td>
                                            <td style="width: 20%; text-align: center;"> {{$goods->desc}} </td>
                                            <td style="width: 20%; text-align: center;"> {{$goods->type == '1' ? trans('home.service_type_1') : trans('home.service_type_2')}} </td>
                                            <td style="width: 20%; text-align: center;"> ￥{{$goods->price}} </td>
                                            <td style="width: 20%; text-align: center;">
                                                <a href="javascript:buy('{{$goods->id}}');" class="btn blue"> {{trans('home.service_buy_button')}} </a>
                                                <!--<button type="button" class="btn btn-sm blue btn-outline" onclick="exchange('{{$goods->id}}')">兑换</button>-->
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                    {{ $goodsList->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>

    <script type="text/javascript">
        function buy(goods_id) {
            window.location.href = '{{url('user/addOrder?goods_id=')}}' + goods_id;
        }

        // 编辑商品
        function exchange(id) {
            //
        }

        // 查看商品图片
        $(document).ready(function () {
            $('.fancybox').fancybox({
                openEffect: 'elastic',
                closeEffect: 'elastic'
            })
        })
    </script>
@endsection
