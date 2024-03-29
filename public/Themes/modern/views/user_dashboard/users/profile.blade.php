@extends('user_dashboard.layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ theme_asset('public/css/intl-tel-input-13.0.0/build/css/intlTelInput.css')}}">
@endsection

@section('content')

<section class="min-vh-100">
    <div class="my-30">
        <div class="container-fluid">
            <!-- Page title start -->
            <div>
                <h3 class="page-title">{{ __('Settings') }}</h3>
            </div>
            <!-- Page title end-->

            <div class="mt-5 border-bottom">
                <div class="d-flex flex-wrap">
                    <a href="{{ url('/profile') }}">
                        <div class="mr-4 border-bottom-active pb-3">
                            <p class="text-16 font-weight-600 text-active">{{ __('Profile') }}</p>
                        </div>
                    </a>

                    <a href="{{ url('/profile/2fa') }}">
                        <div class="mr-4">
                            <p class="text-16 font-weight-400 text-gray-500"> {{ __('2-FA') }} </p>
                        </div>
                    </a>

                    <a href="{{ url('/profile/personal-id') }}">
                        <div class="mr-4">
                            <p class="text-16 font-weight-400 text-gray-500">{{ __('Identity verification') }}</p>
                        </div>
                    </a>

                    <a href="{{ url('/profile/personal-address') }}">
                        <div class="mr-4">
                            <p class="text-16 font-weight-400 text-gray-500">{{ __('Address verfication') }}</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-4">
                    <!-- Sub title start -->
                    <div class="mt-5">
                        <h3 class="sub-title">{{ __('User profile') }}</h3>
                        <p class="text-gray-500 text-16"> {{ __('Mange your profile') }}</p>
                    </div>
                    <!-- Sub title end-->
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-11">
                            @include('user_dashboard.layouts.common.alert')
                            <div class="bg-secondary mt-3 shadow p-4">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <div class="row px-4 justify-content-between">
                                            <div class="d-flex flex-wrap">
                                                <div class="pr-3">
                                                    @if(!empty(Auth::user()->picture))
                                                        <img src="{{url('public/user_dashboard/profile/'.Auth::user()->picture)}}" class="w-50p rounded-circle" id="profileImage">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-50p w-50p" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                      </svg>
                                                    @endif
                                                </div>

                                                <div>
                                                    <h4 class="font-weight-600 text-16">@lang('message.dashboard.setting.change-avatar')</h4>
                                                    <p>@lang('message.dashboard.setting.change-avatar-here')</p>
                                                    <p class="font-weight-600 text-12">*{{__('Recommended Dimension')}}: 100 px * 100 px</p>

                                                    <input type="file" id="file" style="display: none"/>
                                                    <input type="hidden" id="file_name"/>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="uploadAvatar text-md-right">
                                                    <a href="javascript:changeProfile()" id="changePicture"
                                                        class="btn btn-light w-160p btn-border btn-sm mt-2">
                                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                                        &nbsp; @lang('message.dashboard.button.change-picture')
                                                    </a>
                                                    <p id="file-error" style="display: none;"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-4">
                                        <div class="row px-4 justify-content-between">
                                            <div class="d-flex flex-wrap">
                                                <div class="pr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-50p w-50p" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                </div>

                                                <div>
                                                    <h4 class="font-weight-600 text-16">@lang('message.dashboard.setting.change-password')</h4>
                                                    <p>@lang('message.dashboard.setting.change-password-here')</p>
                                                </div>
                                            </div>

                                            <div>
                                                <div class=" text-md-right">
                                                    <button type="button" class="btn w-160p btn-profile mt-2 text-14" data-toggle="modal"
                                                            data-target="#myModal">
                                                            <i class="fas fa-key"></i> @lang('message.dashboard.button.change-password')
                                                    </button>
                                                </div>
                                                <!-- The Modal -->
                                                <div class="modal" id="myModal">
                                                    <div class="modal-dialog modal-lg">
                                                        <form method="post" action="{{url('prifile/update_password')}}" id="reset_password">
                                                            {{ csrf_field() }}

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title text-18 font-weight-600">@lang('message.dashboard.setting.change-password')</h4>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body px-4">

                                                                    <div class="form-group">
                                                                        <label>@lang('message.dashboard.setting.old-password')</label>
                                                                        <input class="form-control" name="old_password"
                                                                                id="old_password" type="password">
                                                                        @if($errors->has('old_password'))
                                                                            <span class="error">
                                                                                {{ $errors->first('old_password') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group">
                                                                        <label>@lang('message.dashboard.setting.new-password')</label>
                                                                        <input class="form-control" name="password"
                                                                                id="password" type="password">
                                                                        @if($errors->has('password'))
                                                                            <span class="error">
                                                                                {{ $errors->first('password') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <div class="form-group">
                                                                        <label>@lang('message.dashboard.setting.confirm-password')</label>
                                                                        <input class="form-control" name="confirm_password"
                                                                                id="confirm_password" type="password">
                                                                        @if($errors->has('confirm_password'))
                                                                            <span class="error">
                                                                                {{ $errors->first('confirm_password') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="mt-1  mb-2">
                                                                        <div class="row m-0">
                                                                            <div>
                                                                                <button type="submit" class="btn btn-primary px-4 py-2">@lang('message.dashboard.button.submit')</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal footer -->

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (empty($user->phone))
                                    <div class="row mt-4">
                                        <div class="col-lg-12 mt-2">
                                            <div class="row px-4 justify-content-between">
                                                <div class="d-flex flex-wrap">
                                                    <div class="pr-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-50p w-50p" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                    </div>

                                                    <div>
                                                        <h4 class="font-weight-600 text-16">@lang('message.dashboard.setting.add-phone')</h4>
                                                        <p class="addPhoneBody">@lang('message.dashboard.setting.add-phone-subhead1') <b>+</b> @lang('message.dashboard.setting.add-phone-subhead2')</p>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="uploadAvatar text-md-right">
                                                        <button type="button" class="btn btn-profile btn-border w-160p btn-sm add mt-2" data-toggle="modal" data-target="#add">
                                                            <i class="fa fa-plus" id="modalTextSymbol"></i>
                                                            <span class="modalText">&nbsp; @lang('message.dashboard.setting.add-phone')</span>
                                                        </button>
                                                    </div>

                                                    <!-- Add Phone Modal -->
                                                    <div class="modal" id="add">
                                                        <div class="modal-dialog modal-lg">
                                                            <form method="POST" action="{{ url('profile/complete-phone-verification')}}" id="complete-phone-verification">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" value="{{ $is_sms_env_enabled }}" name="is_sms_env_enabled" id="is_sms_env_enabled" />
                                                                <input type="hidden" value="{{ $checkPhoneVerification }}" name="checkPhoneVerification" id="checkPhoneVerification" />

                                                                <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id" />
                                                                <input type="hidden" name="hasVerificationCode" id="hasVerificationCode" />

                                                                <input type="hidden" name="defaultCountry" id="defaultCountry" class="form-control">
                                                                <input type="hidden" name="carrierCode" id="carrierCode" class="form-control">
                                                                <input type="hidden" name="countryName" id="countryName" class="form-control">

                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title text-18 font-weight-600">@lang('message.dashboard.setting.add-phone')</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body px-4">
                                                                        <div class="alert text-center" id="message" style="display: none"></div>
                                                                        <div class="form-group">
                                                                            <label id="subheader_text">@lang('message.dashboard.setting.add-phone-subheadertext')</label>
                                                                            <br>
                                                                            <div class="phone_group">
                                                                                <input type="tel" class="form-control" id="phone" name="phone">
                                                                            </div>
                                                                            <span id="phone-number-error"></span>
                                                                            <span id="tel-number-error"></span>

                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="form-group">
                                                                            <label></label>
                                                                            <input id="phone_verification_code" type="text" maxlength="6" class="form-control" name="phone_verification_code"
                                                                            style="display: none;width: 46%;">
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <div style="margin-top: 6px;">
                                                                                    <span id="static_phone_show" class="static_phone_show" style="display: none;"></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-2">
                                                                                <button type="button" class="btn btn-profile edit" style="display: none;"><i class="fa fa-edit"></i></button>
                                                                            </div>
                                                                        </div>

                                                                            <!-- Modal footer -->
                                                                        <div class="mb-2">
                                                                            <div class="row justify-content-center">
                                                                                <div>
                                                                                    <button type="button" class="btn btn-primary px-4 py-2 next" id="common_button">@lang('message.dashboard.button.next')</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-4">
                                            <div class="row px-4 justify-content-between">
                                                <div>
                                                    <div class="preloader" style="display: none;">
                                                        <div class="preloader-img"></div>
                                                    </div>
                                                    <div class="user-profile-qr-code p-6">
                                                    </div>
                                                </div>

                                                <div>
                                                    <button type="button" class="btn btn-profile btn-border w-160p btn-sm mt-2 update-qr-code" id="qr-code-btn">
                                                        @lang('message.dashboard.button.update-qr-code')
                                                    </button>
                                                    <br>
                                                    <br>
                                                    <button type="button" class="btn btn-border btn-profile btn-sm mt-2 w-160p" id="print-qr-code-btn" style="display: none;">
                                                        {{ __('Print QR Code') }}
                                                    </button>
                                                    <!-- The Modal -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mt-4">
                                        <div class="col-lg-12 mt-2">
                                            <div class="row px-4 justify-content-between">
                                                <div class="d-flex flex-wrap">
                                                    <div class="pr-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-50p w-50p" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                    </div>

                                                    <div>
                                                        <h4 class="font-weight-600 text-16">@lang('message.dashboard.setting.phone-number')</h4>
                                                        <p class="editPhoneBody">{{ auth()->user()->phone }}</p>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="uploadAvatar">
                                                        <button type="button" class="btn btn-profile btn-border w-160p btn-sm editModal mt-2" data-toggle="modal" data-target="#editModal">
                                                            <i class="fa fa-edit"></i>
                                                            <span>&nbsp; @lang('message.dashboard.setting.edit-phone')</span>
                                                        </button>

                                                    </div>
                                                    <!-- The Modal -->
                                                    <div class="modal" id="editModal">
                                                        <div class="modal-dialog modal-lg">

                                                            <form method="POST" action="{{ url('profile/update-phone-number')}}" id="update-phone-number">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" value="{{ $is_sms_env_enabled }}" name="is_sms_env_enabled" id="is_sms_env_enabled">
                                                                <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">

                                                                <input type="hidden" value="{{ $checkPhoneVerification }}" name="editCheckPhoneVerification" id="editCheckPhoneVerification" />
                                                                <input type="hidden" name="editHasVerificationCode" id="editHasVerificationCode" />

                                                                <input type="hidden" name="edit_defaultCountry" id="edit_defaultCountry" value="{{ $user->defaultCountry }}">
                                                                <input type="hidden" name="edit_carrierCode" id="edit_carrierCode" value="{{ $user->carrierCode }}">

                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title text-18 font-weight-600">@lang('message.dashboard.setting.edit-phone')</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body px-4 editModalBody">
                                                                        <div class="alert text-center" id="message" style="display: none"></div>

                                                                        <div class="form-group">
                                                                            <label id="subheader_edit_text">@lang('message.dashboard.setting.add-phone-subheadertext')</label>
                                                                            <br>
                                                                            <div class="phone_group">
                                                                                <input type="tel" class="form-control" id="edit_phone" name="edit_phone" value="{{ '+'.$user->carrierCode.$user->phone }}">
                                                                            </div>
                                                                            <span id="edit-phone-number-error"></span>
                                                                            <span id="edit-tel-number-error"></span>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="form-group">
                                                                            <label></label>
                                                                            <input id="edit_phone_verification_code" type="text" maxlength="6" class="form-control" name="edit_phone_verification_code"
                                                                            style="display: none;width: 46%;">
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <div style="margin-top: 6px;">
                                                                                    <span id="edit_static_phone_show" class="edit_static_phone_show" style="display: none;"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <button type="button" class="btn btn-sm btn-primary px-4 py-2 edit_button_edit" style="display: none;"><i class="fa fa-edit"></i></button>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row justify-content-end pb-2">
                                                                            <div class="pr-4">
                                                                                <button type="button" class="btn btn-cancel px-4 py-2" data-dismiss="modal" id="close">@lang('message.form.cancel')</button>
                                                                            </div>

                                                                            <div class="pr-3">
                                                                                @php
                                                                                    $bothDisabled = ($is_sms_env_enabled == false && $checkPhoneVerification == "Disabled");
                                                                                @endphp

                                                                                @if ($bothDisabled || $checkPhoneVerification == "Disabled")
                                                                                    <button type="button" class="btn btn-primary px-4 py-2 edit_form_submit" id="common_button_update">@lang('message.form.update')</button>
                                                                                @else
                                                                                    <button type="button" class="btn btn-primary px-4 py-2 update" id="common_button_update">@lang('message.dashboard.button.next')</button>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <div class="row px-4 justify-content-between">
                                                <div>
                                                    <div class="preloader" style="display: none;">
                                                        <div class="preloader-img"></div>
                                                    </div>
                                                    <div class="user-profile-qr-code p-6">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mt-4">
                                                        <button type="button" class="btn btn-profile btn-border w-160p btn-sm update-qr-code" id="qr-code-btn">
                                                            @lang('message.dashboard.button.update-qr-code')
                                                        </button>
                                                    </div>

                                                    <div class="mt-4">
                                                        <button type="button" class="btn btn-border btn-profile btn-sm w-160p" id="print-qr-code-btn" style="display: none;">
                                                            {{ __('Print QR Code') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mt-5 pl-3 pr-3">
                                    <div class="col-lg-12">
                                        <h3 class="sub-title">@lang('message.dashboard.setting.profile-information')</h3>

                                            <form method="post" action="{{url('prifile/update')}}" id="profile_update_form">
                                                {{csrf_field()}}

                                                <input type="hidden" value="{{$user->id}}" name="id" id="id" />

                                                <div class="row mt-4">
                                                    <div class="form-group col-md-6">
                                                        <label for="first_name">@lang('message.dashboard.setting.first-name')
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                                                value="{{ $user->first_name }}">
                                                        @if($errors->has('first_name'))
                                                            <span class="error">
                                                                {{ $errors->first('first_name') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="last_name">@lang('message.dashboard.setting.last-name')
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                                                value="{{ $user->last_name }}">
                                                        @if($errors->has('last_name'))
                                                            <span class="error">
                                                                {{ $errors->first('last_name') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="email">@lang('message.dashboard.setting.email')
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
                                                    </div>
                                                    <!-- Default Wallet -->
                                                    <div class="form-group col-md-6">
                                                        <label for="email">@lang('message.dashboard.setting.default-wallet')
                                                        </label>
                                                        <select class="form-control" name="default_wallet" id="default_wallet">
                                                            @foreach($wallets as $wallet)
                                                                <option value="{{$wallet->id}}" {{$wallet->is_default == 'Yes' ? 'Selected' : ''}}>{{$wallet->currency->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="address_1">@lang('message.dashboard.setting.address1')</label>
                                                        <textarea class="form-control" name="address_1"
                                                                    id="address_1">{{ $user->user_detail->address_1 }}</textarea>
                                                        @if($errors->has('address_1'))
                                                            <span class="error">
                                                                {{ $errors->first('address_1') }}
                                                                </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="address_2">@lang('message.dashboard.setting.address2')</label>
                                                        <textarea class="form-control" name="address_2"
                                                                    id="address_2">{{ $user->user_detail->address_2 }}</textarea>
                                                        @if($errors->has('address_2'))
                                                            <span class="error">
                                                                {{ $errors->first('address_2') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="city">@lang('message.dashboard.setting.city')</label>

                                                        <input type="text" class="form-control" name="city" id="city"
                                                                value="{{ $user->user_detail->city }}">
                                                        @if($errors->has('city'))
                                                            <span class="error">
                                                                {{ $errors->first('city') }}
                                                                </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="state">@lang('message.dashboard.setting.state')</label>
                                                        <input type="text" class="form-control" name="state" id="state" value="{{ $user->user_detail->state }}">
                                                        @if($errors->has('state'))
                                                            <span class="error">
                                                                {{ $errors->first('state') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="country_id">@lang('message.dashboard.setting.country')</label>
                                                        <select class="form-control" name="country_id" id="country_id">
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->id}}" <?= ($user->user_detail->country_id == $country->id) ? 'selected' : '' ?> >{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('country_id'))
                                                            <span class="error">
                                                                {{ $errors->first('country_id') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="timezone">@lang('message.dashboard.setting.timezone')</label>

                                                        <select class="form-control" name="timezone" id="timezone">
                                                            @foreach($timezones as $timezone)
                                                                <option value="{{ $timezone['zone'] }}" {{ ($user->user_detail->timezone == $timezone['zone']) ? 'selected' : '' }}>
                                                                {{ $timezone['diff_from_GMT'] . ' - ' . $timezone['zone'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @if($errors->has('timezone'))
                                                            <span class="error">
                                                                {{ $errors->first('timezone') }}
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row mt-1">
                                                    <div class="form-group mb-0 col-md-12">
                                                        <button type="submit" class="btn btn-primary px-4 py-2" id="users_profile">
                                                            <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> <span id="users_profile_text">@lang('message.dashboard.button.submit')</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')

<script src="{{theme_asset('public/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{theme_asset('public/js/additional-methods.min.js')}}" type="text/javascript"></script>
<script src="{{ theme_asset('public/js/intl-tel-input-13.0.0/build/js/intlTelInput.js')}}" type="text/javascript"></script>
<script src="{{theme_asset('public/js/isValidPhoneNumber.js')}}" type="text/javascript"></script>
<script src="{{theme_asset('public/js/sweetalert/sweetalert-unpkg.min.js')}}" type="text/javascript"></script>

<script>

    $(document).on('click','#print-qr-code-btn',function(e)
    {
        e.preventDefault();
        let userId = {{ auth()->user()->id }};
        let printQrCodeUrl = SITE_URL+'/profile/qr-code-print/'+userId+'/user';
        $(this).attr('href', printQrCodeUrl);
        window.open($(this).attr('href'), '_blank');
    });

    //show user's qr-code on window load
    $(window).on('load', function()
    {
        swal("{{ __('Please Wait') }}", "{{ __('Loading...') }}", {
            closeOnClickOutside: false,
            closeOnEsc: false,
            buttons: false,
            timer: 2000,
        });
        var QrCodeSecret = '{{ !empty($QrCodeSecret) ? $QrCodeSecret : '' }}';

        if (QrCodeSecret != '') {
            $('.user-profile-qr-code').html(`<img src="https://api.qrserver.com/v1/create-qr-code/?data=${QrCodeSecret}&amp;size=200x200"/>`);
            $("#qr-code-btn").removeClass('add-qr-code').addClass('update-qr-code').text("{{ __('Update QR Code') }}");
            $("#print-qr-code-btn").show();
        } else {
            $(".user-profile-qr-code").html(`<img class="" src="${SITE_URL}/public/uploads/userPic/default-image.png" class="img-responsive"/>`);
            $("#qr-code-btn").addClass('add-qr-code').text('Add QR Code');
        }

    });

    function addOrUpdateQrCode()
    {
        let user_id = $('#user_id').val();

        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: SITE_URL + "/profile/qr-code/add-or-update",
            dataType: "json",
            data: {
                'user_id': user_id,
            },
            beforeSend: function () {
                swal("{{ __('Please Wait') }}", "{{ __('Loading...') }}", {
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 2000,
                });
            },
        })
        .done(function(response)
        {
            if (response.status == true) {
                $('.user-profile-qr-code').html(`<img src="https://api.qrserver.com/v1/create-qr-code/?data=${response.secret}&amp;size=200x200"/>`);
            }
        })
        .fail(function(error)
        {
            console.log(error);
        });
    }

    // UPDATE USER's QR CODE
    $(document).on('click', '.update-qr-code', function(e)
    {
        e.preventDefault();
        addOrUpdateQrCode();
    });

    // ADD USER's QR CODE
    $(document).on('click', '.add-qr-code', function(e)
    {
        e.preventDefault();
        addOrUpdateQrCode();
        $("#qr-code-btn").removeClass('add-qr-code').addClass('update-qr-code').text("{{ __('Update QR Code') }}");
    });
////////////////////////////////////////////////////////////////
        //Add
            //reload on close of phone add modal
            $('#add').on('hidden.bs.modal', function ()
            {
                if ($("#phone").val() != '') {
                    $(this).find("input").val('').end(); //reset input
                    $('#complete-phone-verification').validate().resetForm(); //reset validation messages
                    window.location.reload();
                }
            });

            /*
            intlTelInput - add
            */
            $(document).ready(function()
            {
                var countryShortCode = '{{ getDefaultCountry() }}';

                $("#phone").intlTelInput({
                    separateDialCode: true,
                    nationalMode: true,
                    preferredCountries: [countryShortCode],
                    autoPlaceholder: "polite",
                    placeholderNumberType: "MOBILE",
                    utilsScript: "{{ theme_asset('public/js/intl-tel-input-13.0.0/build/js/utils.js') }}"
                });

                var countryData = $("#phone").intlTelInput("getSelectedCountryData");
                $('#defaultCountry').val(countryData.iso2);
                $('#carrierCode').val(countryData.dialCode);

                $("#phone").on("countrychange", function(e, countryData)
                {
                    $('#defaultCountry').val(countryData.iso2);
                    $('#carrierCode').val(countryData.dialCode);

                    if ($.trim($(this).val())) {
                        if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                            $('#tel-number-error').addClass('error').html("{{__('Please enter a valid International Phone Number.')}}").css({
                               'color' : '#f50000 !important',
                               'font-size' : '14px',
                               'font-weight' : '400',
                               'padding-top' : '5px',
                            });
                            $('#common_button').prop('disabled',true);
                            $('#phone-number-error').hide();
                        } else {
                            $('#tel-number-error').html('');

                            var id = $('#id').val();
                            $.ajax({
                                headers:
                                {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: "POST",
                                url: SITE_URL+"/profile/duplicate-phone-number-check",
                                dataType: "json",
                                cache: false,
                                data: {
                                    'phone': $.trim($(this).val()),
                                    'carrierCode': $.trim(countryData.dialCode),
                                    'id': id,
                                }
                            })
                            .done(function(response)
                            {
                                if (response.status == true) {
                                    $('#tel-number-error').html('');
                                    $('#phone-number-error').show();

                                    $('#phone-number-error').addClass('error').html(response.fail).css({
                                       'color' : '#f50000 !important',
                                       'font-size' : '14px',
                                       'font-weight' : '400',
                                       'padding-top' : '5px',
                                    });
                                    $('#common_button').prop('disabled',true);
                                } else if (response.status == false) {
                                    $('#tel-number-error').show();
                                    $('#phone-number-error').html('');

                                    $('#common_button').prop('disabled',false);
                                }
                            });
                        }
                    } else {
                        $('#tel-number-error').html('');
                        $('#phone-number-error').html('');
                        $('#common_button').prop('disabled',false);
                    }
                });
            });
            /*
            intlTelInput - add
            */

            //Invalid Number Validation - add
            $(document).ready(function()
            {
                $("#phone").on('blur', function(e)
                {
                    if ($.trim($(this).val())) {
                        if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                            // alert('invalid');
                            $('#tel-number-error').addClass('error').html("{{__('Please enter a valid International Phone Number.')}}").css({
                               'color' : '#f50000 !important',
                               'font-size' : '14px',
                               'font-weight' : '400',
                               'padding-top' : '5px',
                            });
                            $('#common_button').prop('disabled',true);
                            $('#phone-number-error').hide();
                        } else {
                            var id = $('#id').val();
                            var phone = $(this).val().replace(/-|\s/g,""); //replaces 'whitespaces', 'hyphens'
                            var phone = $(this).val().replace(/^0+/, ""); //replaces (leading zero - for BD phone number)

                            var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;

                            if (phone.length == 0) {
                                $('#phone-number-error').addClass('error').html("{{ __('This field is required.') }}").css({
                                   'color' : '#f50000 !important',
                                   'font-size' : '14px',
                                   'font-weight' : '400',
                                   'padding-top' : '5px',
                                });
                                $('#common_button').prop('disabled',true);
                            } else {
                                $('#phone-number-error').hide();
                                $('#common_button').prop('disabled',false);
                            }

                            $.ajax({
                                headers:
                                {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: "POST",
                                url: SITE_URL+"/profile/duplicate-phone-number-check",
                                dataType: "json",
                                cache: false,
                                data: {
                                    'phone': phone,
                                    'id': id,
                                    'carrierCode': pluginCarrierCode,
                                }
                            })
                            .done(function(response)
                            {
                                $('#phone-number-error').show();
                                if (response.status == true) {
                                    if (phone.length == 0) {
                                        $('#phone-number-error').html('');
                                    } else {
                                        $('#phone-number-error').addClass('error').html(response.fail).css({
                                           'color' : '#f50000 !important',
                                           'font-size' : '14px',
                                           'font-weight' : '400',
                                           'padding-top' : '5px',
                                        });
                                        $('#common_button').prop('disabled',true);
                                    }
                                } else if (response.status == false) {
                                    $('#common_button').prop('disabled',false);
                                    $('#phone-number-error').html('');
                                }
                            });
                            $('#tel-number-error').html('');
                            $('#phone-number-error').show();
                            $('#common_button').prop('disabled',false);
                        }
                    } else {
                        $('#tel-number-error').html('');
                        $('#phone-number-error').html('');
                        $('#common_button').prop('disabled',false);
                    }
                });
            });


            //is_sms_env_enabled and phone verification check
            $(document).ready(function()
            {
                var is_sms_env_enabled = $('#is_sms_env_enabled').val();
                var checkPhoneVerification = $('#checkPhoneVerification').val();

                if ((is_sms_env_enabled != true && checkPhoneVerification != "Enabled") || checkPhoneVerification != "Enabled") {
                    $('.next').removeClass("next").addClass('form_submit').html("{{ __('Submit') }}");
                } else {
                    $('.next').removeClass("form_submit").addClass('next').html("{{ __('Next') }}");
                }
            });

            // next
            $(document).on('click', '.next', function()
            {
                var phone = $("input[name=phone]");
                if (phone.val() == '') {
                    $('#phone-number-error').addClass('error').html("{{ __('This field is required.') }}").css({
                       'color' : '#f50000 !important',
                       'font-size' : '14px',
                       'font-weight' : '400',
                       'padding-top' : '5px',
                    });
                    return false;
                } else if(phone.hasClass('error')) {
                    return false;
                }
                else
                {
                    $('.modal-title').html("{{__('Get Code')}}");
                    $('#subheader_text').html("{{ __('To make sure this number is yours, we will send you a verification code.') }}");
                    $('.phone_group').hide();
                    $('#static_phone_show').show();
                    $('.edit').show();

                    $(this).removeClass("next").addClass("get_code").html("{{ __('Get Code') }}");
                    var fullPhone = $("#phone").intlTelInput("getNumber");
                    $('#static_phone_show').html(fullPhone + '&nbsp;&nbsp;');
                    return true;
                }
            });

            //edit - add_phone
            $(document).on('click', '.edit', function()
            {
                $('.get_code').removeClass("get_code").addClass("next").html("{{ __('Next') }}");
                $('.static_phone_show').html('');
                $(this).hide();
                $('#subheader_text').html("{{ __('Enter the number you’d like to use') }}");
                $('.phone_group').show();
            });


            //get_code
            $(document).on('click', '.get_code', function()
            {
                $('.modal-title').html("{{ __('Verify Phone') }}");
                $('.phone_group').hide();
                $('.static_phone_show').html('');

                $('#subheader_text').html('{{ __("We just sent you a SMS with a code.") }}'+ '<br><br>' + '{{ __("Enter it to verify your phone.") }}');

                $('#subheader_text').html('{{ __("We just sent you a SMS with a code.") }}'+ '<br><br>' + '{{ __("Enter it to verify your phone.") }}');

                $('.edit').hide();
                $('#phone_verification_code').show().val('');
                $(this).removeClass("get_code").addClass("verify").html("{{ __("Verify") }}");

                var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;
                var pluginPhone = $("#phone").intlTelInput("getNumber");

                $.ajax({
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: SITE_URL+"/profile/getVerificationCode",
                    dataType: "json",
                    cache: false,
                    data: {
                        'phone': pluginPhone,
                        'carrierCode': pluginCarrierCode,
                    }
                })
                .done(function(response)
                {
                    if (response.status == true) {
                        $('#hasVerificationCode').val(response.message);
                    }
                });
            });

            //verify
            $(document).on('click', '.verify', function()
            {
                var classOfSubmit = $('#common_button');
                var phone_verification_code = $("#phone_verification_code").val();

                var pluginPhone = $("#phone").intlTelInput("getNumber");
                var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;
                var pluginDefaultCountry = $('#phone').intlTelInput('getSelectedCountryData').iso2;

                if (classOfSubmit.hasClass('verify')) {
                    $.ajax({
                        headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        url: SITE_URL+"/profile/complete-phone-verification",
                        dataType: "json",
                        cache: false,
                        data: {
                            'phone': pluginPhone,
                            'defaultCountry': pluginDefaultCountry,
                            'carrierCode': pluginCarrierCode,
                            'phone_verification_code': phone_verification_code,
                        }
                    })
                    .done(function(data)
                    {
                        if (data.status == false || data.status == 500) {
                            $('#message').css('display', 'block');
                            $('#message').html(data.message);
                            $('#message').addClass(data.error);
                        } else {
                            $('#message').removeClass('alert-danger');
                            $('#message').css('display', 'block');
                            $('#message').html(data.message);
                            $('#message').addClass(data.success);

                            $('#subheader_text').hide();
                            $('#phone_verification_code').hide();
                            $('#common_button').hide();
                            $('#close').hide();
                            $('.modal-title').hide();
                        }
                    });
                }
            });

            //form_submit
            $(document).on('click', '.form_submit', function()
            {
                var classOfSubmit = $('#common_button');
                if (classOfSubmit.hasClass('form_submit')) {
                    var pluginPhone = $("#phone").intlTelInput("getNumber");
                    var pluginDefaultCountry = $('#phone').intlTelInput('getSelectedCountryData').iso2;
                    var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;

                    $.ajax({
                        headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        url: SITE_URL+"/profile/add-phone-number",
                        dataType: "json",
                        cache: false,
                        data: {
                            'phone': pluginPhone,
                            'defaultCountry': pluginDefaultCountry,
                            'carrierCode': pluginCarrierCode,
                        }
                    })
                    .done(function(data)
                    {
                        if (data.status == true) {
                            $('#message').css('display', 'block');
                            $('#message').html(data.message);
                            $('#message').addClass(data.class_name);

                            $('#subheader_text').hide();
                            $('#common_button').hide();
                            $('#close').hide();
                            $('.phone_group').hide();
                        }
                    });
                }
            });

    //Update

        //clear inputs on close - edit modal
        $('#editModal').on('hidden.bs.modal', function () {
            if ($("#edit_phone").val() != '') {
                var OrginalUsercarrierCode = '{{ $user->carrierCode }}';
                var OrginalUserphone = '{{ $user->phone }}';
                $("#edit_phone").val(`+${OrginalUsercarrierCode}${OrginalUserphone}`)
                window.location.reload(); //need to reload - or validation message still exists.
            }
        });

         /*
        intlTelInput - edit
        */
        $(document).ready(function()
        {
            $("#edit_phone").intlTelInput({
                separateDialCode: true,
                nationalMode: true,
                preferredCountries: ["us"],
                autoPlaceholder: "polite",
                placeholderNumberType: "MOBILE",
                formatOnDisplay: false,
                utilsScript: "{{ theme_asset('public/js/intl-tel-input-13.0.0/build/js/utils.js') }}"

            })
            .done(function()
            {
                let carrierCode = '{{ !empty($user->carrierCode) ? $user->carrierCode : NULL }}';
                let defaultCountry = '{{ !empty($user->defaultCountry) ? $user->defaultCountry : NULL }}';
                let formattedPhone = '{{ !empty($user->formattedPhone) ? $user->formattedPhone : NULL }}';
                if (formattedPhone !== null && carrierCode !== null && defaultCountry !== null) {
                    $("#edit_phone").intlTelInput("setNumber", formattedPhone);
                    $('#edit_defaultCountry').val(defaultCountry);
                    $('#edit_carrierCode').val(carrierCode);
                }
            });
        });

        var editCountryData = $("#edit_phone").intlTelInput("getSelectedCountryData");
        $("#edit_phone").on("countrychange", function(e, editCountryData)
        {
            $('#edit_defaultCountry').val(editCountryData.iso2);
            $('#edit_carrierCode').val(editCountryData.dialCode);

            if ($.trim($(this).val())) {
                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#edit-tel-number-error').addClass('error').html("{{ __('Please enter a valid International Phone Number.') }}").css({
                       'color' : '#f50000 !important',
                       'font-size' : '14px',
                       'font-weight' : '400',
                       'padding-top' : '5px',
                    });
                    $('#common_button_update').prop('disabled',true);
                    $('#edit-phone-number-error').hide();
                } else {
                    $('#edit-tel-number-error').html('');

                    var id = $('#id').val();
                    $.ajax({
                        headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        url: SITE_URL+"/profile/duplicate-phone-number-check",
                        dataType: "json",
                        cache: false,
                        data: {
                            'phone': $.trim($(this).val()),
                            'carrierCode': $.trim(countryData.dialCode),
                            'id': id,
                        }
                    })
                    .done(function(response)
                    {
                        if (response.status == true) {
                            $('#edit-tel-number-error').html('');
                            $('#edit-phone-number-error').show();

                            $('#edit-phone-number-error').addClass('error').html(response.fail).css("font-weight", "bold");
                            $('#common_button_update').prop('disabled',true);
                        } else if (response.status == false) {
                            $('#edit-tel-number-error').show();
                            $('#edit-phone-number-error').html('');

                            $('#common_button_update').prop('disabled',false);
                        }
                    });
                }
            } else {
                $('#edit-tel-number-error').html('');
                $('#edit-phone-number-error').html('');
                $('#common_button_update').prop('disabled',false);
            }
        });

        //Invalid Number Validation - user edit
        $(document).ready(function()
        {
            $("#edit_phone").on('blur', function(e)
            {
                if ($.trim($(this).val())) {
                    if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                        $('#edit-tel-number-error').addClass('error').html("{{ __("Please enter a valid International Phone Number.") }}").css({
                           'color' : '#f50000 !important',
                           'font-size' : '14px',
                           'font-weight' : '400',
                           'padding-top' : '5px',
                        });
                        $('#common_button_update').prop('disabled',true);
                        $('#edit-phone-number-error').hide();
                    } else {
                        var id = $('#user_id').val();

                        var phone = $(this).val().replace(/-|\s/g,""); //replaces 'whitespaces', 'hyphens'
                        var phone = $(this).val().replace(/^0+/,"");  //replaces (leading zero - for BD phone number)

                        var pluginCarrierCode = $(this).intlTelInput('getSelectedCountryData').dialCode;

                        $.ajax({
                            headers:
                            {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            url: SITE_URL+"/profile/duplicate-phone-number-check",
                            dataType: "json",
                            cache: false,
                            data: {
                                'id': id,
                                'phone': phone,
                                'carrierCode': $.trim(pluginCarrierCode),
                            }
                        })
                        .done(function(response)
                        {
                            if (response.status == true) {
                                if (phone.length == 0) {
                                    $('#edit-phone-number-error').html('');
                                } else {
                                    $('#edit-phone-number-error').addClass('error').html(response.fail).css({
                                       'color' : '#f50000 !important',
                                       'font-size' : '14px',
                                       'font-weight' : '400',
                                       'padding-top' : '5px',
                                    });
                                    $('#common_button_update').prop('disabled',true);
                                }
                            } else if (response.status == false) {
                                $('#common_button_update').prop('disabled',false);
                                $('#edit-phone-number-error').html('');
                            }
                        });
                        $('#edit-tel-number-error').html('');
                        $('#edit-phone-number-error').show();
                        $('#common_button_update').prop('disabled',false);
                    }
                } else {
                    $('#edit-tel-number-error').html('');
                    $('#edit-phone-number-error').html('');
                    $('#common_button_update').prop('disabled',false);
                }
            });
        });

        // Duplicate Validate phone via Ajax - update

         /*
        intlTelInput - edit
        */

        //when phone verificaiton is enabled
        $(document).on('click', '.update', function()
        {
            var phone = $("input[name=edit_phone]");
            if (phone.val() == '') {
                $('#edit-phone-number-error').addClass('error').html("{{ __('This field is required.') }}").css({
                   'color' : '#f50000 !important',
                   'font-size' : '14px',
                   'font-weight' : '400',
                   'padding-top' : '5px',
                });
                return false;
            } else if(phone.hasClass('error')) {
                return false;
            } else {
                $('.modal-title').html("{{ __('Get Code') }}");

                $('#subheader_edit_text').html("{{ __('To make sure this number is yours, we will send you a verification code.') }}");

                $('.phone_group').hide();

                $('#edit_static_phone_show').show();

                $('.edit_button_edit').show();

                $(this).removeClass("update").addClass("edit_get_code").html("{{ __('Get Code') }}");

                var edit_phone = $("#edit_phone").intlTelInput("getNumber");
                $('#edit_static_phone_show').html(edit_phone + '&nbsp;&nbsp;');
                return true;
            }
        });

        //edit_get_code
        $(document).on('click', '.edit_get_code', function()
        {
            $('.modal-title').html("{{__('Verify Phone')}}");
            $(this).removeClass("edit_get_code").addClass("edit_verify").html("{{__('Verify')}}");
            $('.phone_group').hide();
            $('.edit_button_edit').hide();
            $('.edit_static_phone_show').html('');
            $('#subheader_edit_text').html('{{ __("We just sent you a SMS with a code.") }}'+ '<br><br>' + '{{ __("Enter it to verify your phone.") }}.');
            $('#edit_phone_verification_code').show().val('');

            var pluginPhone = $("#edit_phone").intlTelInput("getNumber");
            var pluginCarrierCode = $('#edit_phone').intlTelInput('getSelectedCountryData').dialCode;

            $.ajax({
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: SITE_URL+"/profile/editGetVerificationCode",
                dataType: "json",
                cache: false,
                data: {
                    'phone': pluginPhone,
                    'code': pluginCarrierCode,
                }
            })
            .done(function(response)
            {
                if (response.status == true) {
                    $('#editHasVerificationCode').val(response.message);
                }
            });
        });

        //edit_verify
        $(document).on('click', '.edit_verify', function()
        {
            var classOfSubmit = $('#common_button_update');

            var edit_phone_verification_code = $("#edit_phone_verification_code").val();

            var pluginPhone = $("#edit_phone").intlTelInput("getNumber");
            var pluginDefaultCountry = $('#edit_phone').intlTelInput('getSelectedCountryData').iso2;
            var pluginCarrierCode = $('#edit_phone').intlTelInput('getSelectedCountryData').dialCode;


            if (classOfSubmit.hasClass('edit_verify')) {
                $.ajax({
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: SITE_URL+"/profile/edit-complete-phone-verification",
                    dataType: "json",
                    cache: false,
                    data: {
                        'phone': pluginPhone,
                        'flag': pluginDefaultCountry,
                        'code': pluginCarrierCode,
                        'edit_phone_verification_code': edit_phone_verification_code,
                    }
                })
                .done(function(data)
                {
                    if (data.status == false || data.status == 500) {
                        $('#message').css('display', 'block');
                        $('#message').html(data.message);
                        $('#message').addClass(data.error);
                    } else {
                        $('#message').removeClass('alert-danger');
                        $('#message').css('display', 'block');
                        $('#message').html(data.message);
                        $('#message').addClass(data.success);

                        $('#subheader_edit_text').hide();
                        $('#edit_phone_verification_code').hide();
                        $('#common_button_update').hide();
                        $('#close').hide();
                        $('.modal-title').hide();
                    }
                });
            }
        });

        //when phone verificaiton is disabled
        $(document).on('click', '.edit_form_submit', function()
        {
            var classOfSubmit = $('#common_button_update');
            if (classOfSubmit.hasClass('edit_form_submit')) {
                var pluginPhone = $("#edit_phone").intlTelInput("getNumber");
                var pluginDefaultCountry = $('#edit_phone').intlTelInput('getSelectedCountryData').iso2;
                var pluginCarrierCode = $('#edit_phone').intlTelInput('getSelectedCountryData').dialCode;

                $.ajax({
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: SITE_URL+"/profile/update-phone-number",
                    dataType: "json",
                    cache: false,
                    data: {
                        'phone': pluginPhone,
                        'flag': pluginDefaultCountry,
                        'code': pluginCarrierCode,
                    }
                })
                .done(function(data)
                {
                    if (data.status == true) {
                        $('#message').css('display', 'block');
                        $('#message').html(data.message);
                        $('#message').addClass(data.class_name);

                        $('#subheader_edit_text').hide();
                        $('#common_button_update').hide();
                        $('#close').hide();
                        $('.phone_group').hide();
                        $('.modal-title').hide();
                    }
                });
            }
        });


        //start - ajax image upload
            function changeProfile() {
                $('#file').click();
            }
            $('#file').change(function () {
                if ($(this).val() != '') {
                    upload(this);
                }
            });
            function upload(img) {
                var form_data = new FormData();
                form_data.append('file', img.files[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#loading').css('display', 'block');
                $.ajax({
                    url: "{{url('profile-image-upload')}}",
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data.fail) {
                            $('#file-error').show().addClass('error').html(data.errors.file).css({
                               'color' : '#f50000 !important',
                               'font-size' : '14px',
                               'font-weight' : '400',
                               'padding-top' : '5px',
                            });
                        } else {
                            $('#file-error').hide();
                            $('#file_name').val(data);
                            $('#profileImage').attr('src', '{{ asset('public/user_dashboard/profile') }}/' + data);
                            $('#profileImageHeader').attr('src', '{{ asset('public/user_dashboard/profile') }}/' + data);
                            $('#profileImageHeaderdrop').attr('src', '{{ asset('public/user_dashboard/profile') }}/' + data);
                        }
                        $('#loading').css('display', 'none');
                    },
                    error: function (xhr, status, error) {
                    }
                });
            }
        //end - ajax image upload

           jQuery.extend(jQuery.validator.messages, {
                required: "{{__('This field is required.')}}",
                minlength: $.validator.format( "{{ __("Please enter at least") }}"+" {0} "+"{{ __("characters.") }}" ),
            })
        //validation -rest
            $("#reset_password").validate({
                rules: {
                    old_password: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                    },
                    confirm_password: {
                        equalTo: "#password",
                        minlength: 6,
                    }
                },
                messages: {
                    password: {
                        required: "{{ __('This field is required.') }}",
                    },
                    confirm_password: {
                        equalTo: "{{ __('Please enter the same value again.') }}",
                    },
                }
            });

            $('#profile_update_form').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                },
                submitHandler: function(form)
                {
                    $("#users_profile").attr("disabled", true);
                    $(".spinner").show();
                    $("#users_profile_text").text("{{ __('Submitting...') }}");
                    form.submit();
                }
            });

</script>
@endsection

