@extends('user.layouts')

@section('css')
    <style type="text/css">
        .ticker {
            background-color: #fff;
            margin-bottom: 20px;
            border: 1px solid #e7ecf1 !important;
            border-radius: 4px;
            -webkit-border-radius: 4px;
        }

        .ticker ul {
            padding: 0;
        }

        .ticker li {
            list-style: none;
            padding: 15px;
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <!-- BEGIN PAGE BASE CONTENT -->
        @if (Session::has('successMsg'))
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button>
                {{Session::get('successMsg')}}
            </div>
        @endif

        <div class="row">
            <div class="portlet light form-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-link font-blue"></i>
                        <span class="caption-subject font-blue bold">账户信息</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="mt-clipboard-container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        服务状态：{{$info['status']!=-1 ? trans('home.enabled') : trans('home.disabled') }}
                                    </li>
                                    <li class="list-group-item">
                                        账户状态：{{$info['enable'] ? trans('home.enabled') : trans('home.disabled') }}
                                    </li>
                                    @if($login_add_score)
                                        <li class="list-group-item">
                                            {{trans('home.account_score')}}：{{$info['score']}}
                                            <span class="badge badge-info">
                            <a href="javascript:;" data-toggle="modal" data-target="#exchange_modal"
                               style="color:#FFF;">{{trans('home.redeem_coupon')}}</a>
                        </span>
                                        </li>
                                    @endif
                                    <li class="list-group-item">
                                        {{trans('home.account_balance')}}：{{$info['balance']}}
                                        <span class="badge badge-danger">
                            <a href="javascript:;" data-toggle="modal" data-target="#charge_modal"
                               style="color:#FFF;">{{trans('home.recharge')}}</a>
                        </span>
                                    </li>
                                    <li class="list-group-item">
                                        {{trans('home.account_expire')}}
                                        ：{{date('Y-m-d 0:0:0') > $info['expire_time'] ? trans('home.expired') : $info['expire_time'].' 24:00:00'}}
                                    </li>
                                    <li class="list-group-item">
                                        {{trans('home.account_last_usage')}}
                                        ：{{empty($info['t']) ? trans('home.never_used') : date('Y-m-d H:i:s', $info['t'])}}
                                    </li>
                                    <li class="list-group-item">
                                        {{trans('home.account_last_login')}}
                                        ：{{empty($info['last_login']) ? trans('home.never_loggedin') : date('Y-m-d H:i:s', $info['last_login'])}}
                                    </li>
                                    <li class="list-group-item">
                                        {{trans('home.account_bandwidth_usage')}}：{{$info['usedTransfer']}}
                                        （{{$info['totalTransfer']}}
                                        ）@if($info['traffic_reset_day']) &ensp;{{trans('home.account_reset_notice', ['reset_day' => $info['traffic_reset_day']])}}  @endif
                                        <div class="progress progress-striped active" style="margin-bottom:0;"
                                             title="{{trans('home.account_total_traffic')}} {{$info['totalTransfer']}}，{{trans('home.account_usage_traffic')}} {{$info['usedTransfer']}}">
                                            <div class="progress-bar progress-bar-danger" role="progressbar"
                                                 aria-valuenow="{{$info['usedPercent'] * 100}}" aria-valuemin="0"
                                                 aria-valuemax="100"
                                                 style="width: {{$info['usedPercent'] * 100}}%">
                                            <span class="sr-only"> {{$info['usedTransfer']}}
                                                / {{$info['totalTransfer']}} </span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                            <p style="font-size: 1.2em">根据您购买的服务，下面是您的可用节点。您更新订阅时，客户端服务器列表跟下面保持一致。</p>
                            <p style="font-size: 1.2em;color: red;">如果您看不到任何节点信息，<b><a href="{{url('user/goodsList')}}">请点我购买服务</a></b> </p>

                            </div>
                        @foreach($nodeList as $node)
                                <div class="col-md-6">
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 light bordered portlet" >
                                        <h4 class="widget-thumb-heading">{{$node->name}}</h4>
                                        <div class="widget-thumb-wrap">
                                            <div style="float:left;display: inline-block;padding-right:15px;">
                                                @if($node->country_code)
                                                    <img src="{{asset('assets/images/country/' . $node->country_code . '.png')}}"/>
                                                @else
                                                    <img src="{{asset('/assets/images/country/un.png')}}"/>
                                                @endif
                                            </div>
                                            <div class="widget-thumb-body">
                                        <span class="widget-thumb-subtitle"><a data-toggle="modal"
                                                                               href="#txt_{{$node->id}}">{{$node->server ? $node->server : $node->ip}}</a></span>
                                                <span class="widget-thumb-body-stat">
                                                @if($node->online_status)
                                                        <a class="btn btn-sm green">正常</a>
                                                    @else
                                                        <a class="btn btn-sm red">宕机</a>
                                                    @endif
                                                    <a class="btn btn-sm green btn-outline" data-toggle="modal"
                                                       href="#link_{{$node->id}}"> <i
                                                                class="fa fa-paper-plane"></i> </a>
                                                <a class="btn btn-sm green btn-outline" data-toggle="modal"
                                                   href="#qrcode_{{$node->id}}"> <i class="fa fa-qrcode"></i> </a>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <div id="charge_modal" class="modal fade" tabindex="-1" data-focus-on="input:first" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{trans('home.recharge_balance')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display: none; text-align: center;"
                         id="charge_msg"></div>
                    <form action="#" method="post" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="charge_type"
                                       class="col-md-4 control-label">{{trans('home.payment_method')}}</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="charge_type" id="charge_type">
                                        <option value="1" selected>充值券</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="charge_coupon"
                                       class="col-md-4 control-label"> {{trans('home.coupon_code')}} </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="charge_coupon" id="charge_coupon"
                                           placeholder="请输入您的充值码">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('home.close')}}</button>
                    <button type="button" class="btn red btn-outline"
                            onclick="return charge();">{{trans('home.recharge')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="exchange_modal" class="modal fade" tabindex="-1" data-focus-on="input:first" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"> {{trans('home.redeem_score')}} </h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info"
                         id="msg">{{trans('home.redeem_info', ['score' => $info['score']])}}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('home.close')}}</button>
                    <button type="button" class="btn red btn-outline"
                            onclick="return exchange();">{{trans('home.redeem')}}</button>
                </div>
            </div>
        </div>
    </div>

    @foreach ($nodeList as $node)
        <div class="modal fade draggable-modal" id="txt_{{$node->id}}" tabindex="-1" role="basic"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">{{trans('home.setting_info')}}</h4>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" rows="10" readonly="readonly">{{$node->txt}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade draggable-modal" id="link_{{$node->id}}" tabindex="-1" role="basic"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Scheme Links - {{$node->name}}</h4>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" rows="5" readonly="readonly">{{$node->ssr_scheme}}</textarea>
                        <a href="{{$node->ssr_scheme}}" class="btn purple uppercase"
                           style="display: block; width: 100%;margin-top: 10px;">打开SSR</a>
                        @if($node->ss_scheme)
                            <p></p>
                            <textarea class="form-control" rows="3"
                                      readonly="readonly">{{$node->ss_scheme}}</textarea>
                            <a href="{{$node->ss_scheme}}" class="btn blue uppercase"
                               style="display: block; width: 100%;margin-top: 10px;">打开SS</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="qrcode_{{$node->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog @if(!$node->compatible) modal-sm @endif">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">{{trans('home.scan_qrcode')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if ($node->compatible)
                                <div class="col-md-6">
                                    <div id="qrcode_ssr_img_{{$node->id}}" style="text-align: center;"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="qrcode_ss_img_{{$node->id}}" style="text-align: center;"></div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div id="qrcode_ssr_img_{{$node->id}}" style="text-align: center;"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/jquery-qrcode/jquery.qrcode.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/js/layer/layer.js" type="text/javascript"></script>

    <script type="text/javascript">
        // 充值
        function charge() {
            var _token = '{{csrf_token()}}';
            var charge_type = $("#charge_type").val();
            var charge_coupon = $("#charge_coupon").val();

            if (charge_type == '1' && (charge_coupon == '' || charge_coupon == undefined)) {
                $("#charge_msg").show().html("{{trans('home.coupon_not_empty')}}");
                $("#charge_coupon").focus();
                return false;
            }

            $.ajax({
                url: '{{url('user/charge')}}',
                type: "POST",
                data: {_token: _token, coupon_sn: charge_coupon},
                beforeSend: function () {
                    $("#charge_msg").show().html("{{trans('home.recharging')}}");
                },
                success: function (ret) {
                    if (ret.status == 'fail') {
                        $("#charge_msg").show().html(ret.message);
                        return false;
                    }

                    $("#charge_modal").modal("hide");
                    window.location.reload();
                },
                error: function () {
                    $("#charge_msg").show().html("{{trans('home.error_response')}}");
                },
                complete: function () {
                }
            });
        }

        // 积分兑换流量
        function exchange() {
            $.ajax({
                type: "POST",
                url: "{{url('user/exchange')}}",
                async: false,
                data: {_token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (ret) {
                    layer.msg(ret.message, {time: 1000}, function () {
                        if (ret.status == 'success') {
                            window.location.reload();
                        }
                    });
                }
            });

            return false;
        }
    </script>

    <script type="text/javascript">
        var UIModals = function () {
            var n = function () {
                @foreach($nodeList as $node)
                $("#txt_{{$node->id}}").draggable({handle: ".modal-header"});
                $("#qrcode_{{$node->id}}").draggable({handle: ".modal-header"});
                @endforeach
            };

            return {
                init: function () {
                    n()
                }
            }
        }();

        jQuery(document).ready(function () {
            UIModals.init()
        });

        // 循环输出节点scheme用于生成二维码
        @foreach ($nodeList as $node)
        $('#qrcode_ssr_img_{{$node->id}}').qrcode("{{$node->ssr_scheme}}");
        $('#qrcode_ss_img_{{$node->id}}').qrcode("{{$node->ss_scheme}}");
        @endforeach

        // 节点订阅
        function subscribe() {
            window.location.href = '{{url('/user/subscribe')}}';
        }

        // 显示加密、混淆、协议
        function show(txt) {
            layer.msg(txt);
        }

        // 更换订阅地址
        function exchangeSubscribe() {
            layer.confirm('更换订阅地址将导致：<br>1.旧地址立即失效；<br>2.连接密码被更改；', {icon: 7, title: '警告'}, function (index) {
                $.post("{{url('user/exchangeSubscribe')}}", {_token: '{{csrf_token()}}'}, function (ret) {
                    layer.msg(ret.message, {time: 1000}, function () {
                        if (ret.status == 'success') {
                            window.location.reload();
                        }
                    });
                });

                layer.close(index);
            });
        }
    </script>
@endsection
