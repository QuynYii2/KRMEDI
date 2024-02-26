@extends('layouts.admin')
@section('title', 'General configuration')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Cấu hình chung') }} </h1>
    @if(!$settingConfig)
        <form id="form" action="{{route('api.backend.setting.create')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-4"><label>{{ __('home.logo') }} </label>
                    <input required type="file" class="form-control" id="logo" name="logo[]"
                           multiple accept="image/*">
                </div>
                <div class="col-sm-4"><label>{{ __('home.favicon') }} </label>
                    <input required type="file" class="form-control" id="favicon" name="favicon[]"
                           multiple accept="image/*">
                </div>
                <div class="col-sm-4"><label>{{ __('home.Banner quảng cáo') }} </label>
                    <input required type="file" class="form-control" id="ad_banner_position" name="ad_banner_position[]"
                           multiple accept="image/*">
                </div>
            </div>
            <div class="form-group">
                <label for="website_description">{{ __('home.Mô tả ngắn việt') }} </label>
                <textarea class="form-control" name="website_description"
                          id="website_description" required></textarea>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="address">{{ __('home.Địa chỉ') }} </label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="col-sm-4">
                    <label for="email">{{ __('home.Email') }} </label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-sm-4">
                    <label for="phone">{{ __('home.PhoneNumber') }} </label>
                    <input type="number" class="form-control" id="phone" name="phone" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="facebook">facebook</label>
                    <input type="text" class="form-control" id="facebook" name="facebook" required>
                </div>
                <div class="col-sm-4">
                    <label for="twitter">twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" required>
                </div>
                <div class="col-sm-4">
                    <label for="instagram">instagram</label>
                    <input type="text" class="form-control" id="instagram" name="instagram" required>
                </div>
                <div class="col-sm-4">
                    <label for="zalo">zalo</label>
                    <input type="text" class="form-control" id="zalo" name="zalo" required>
                </div>
                <div class="col-sm-4">
                    <label for="kakao">kakao</label>
                    <input type="text" class="form-control" id="kakao" name="kakao" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
        </form>
    @else
        <form id="form" action="{{route('api.backend.setting.update',$settingConfig->id)}}" method="post"
              enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="row">
                <div class="col-sm-4"><label>{{ __('home.logo') }}</label>
                    <input type="file" class="form-control" id="logo" name="logo[]" multiple accept="image/*"
                           value="{{$settingConfig->logo}}">
                    <div class="d-flex">
                        @php
                            $galleryArray = explode(',', $settingConfig->logo);
                        @endphp
                        @foreach($galleryArray as $index => $productImg)
                            <div class="image-container pr-2" data-index="{{ $index }}">
                                <img loading="lazy" class="image" width="50px" height="50px" src="{{ $productImg }}"
                                     alt="logo">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-4"><label>{{ __('home.favicon') }}</label>
                    <input type="file" class="form-control" id="favicon" name="favicon[]" multiple accept="image/*"
                           value="{{$settingConfig->favicon}}">
                    <div class="d-flex">
                        @php
                            $galleryArray = explode(',', $settingConfig->favicon);
                        @endphp
                        @foreach($galleryArray as $index => $productImg)
                            <div class="image-container pr-2" data-index="{{ $index }}">
                                <img loading="lazy" class="image" width="50px" height="50px" src="{{ $productImg }}"
                                     alt="favicon">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-4"><label>{{ __('home.Banner quảng cáo') }}</label>
                    <input type="file" class="form-control" id="ad_banner_position" name="ad_banner_position[]" multiple
                           accept="image/*" value="{{$settingConfig->ad_banner_position}}">
                    <div class="d-flex">
                        @php
                            $galleryArray = explode(',', $settingConfig->ad_banner_position);
                        @endphp
                        @foreach($galleryArray as $index => $productImg)
                            <div class="image-container pr-2" data-index="{{ $index }}">
                                <img loading="lazy" class="image" width="50px" height="50px" src="{{ $productImg }}"
                                     alt="Banner quảng cáo">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('home.Mô tả ngắn việt') }}</label>
                <textarea class="form-control" name="website_description" required
                          id="website_description">{{$settingConfig->website_description}}</textarea>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>{{ __('home.Địa chỉ') }}</label>
                    <input type="text" class="form-control" id="address" name="address" required
                           value="{{$settingConfig->address}}">
                </div>
                <div class="col-sm-4">
                    <label>{{ __('home.Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="{{$settingConfig->email}}">
                </div>
                <div class="col-sm-4">
                    <label>{{ __('home.PhoneNumber') }}</label>
                    <input type="number" class="form-control" id="phone" name="phone" required
                           value="{{$settingConfig->phone}}">
                </div>
            </div>
            <div class="row">
                @php
                    $socialLinks = $settingConfig->social_links;
                $listSocialLinks = explode(',', $socialLinks);
                @endphp
                <div class="col-sm-4">
                    <label>facebook</label>
                    <input type="text" class="form-control" id="facebook" name="facebook" required
                           value="{{$listSocialLinks[0]}}">
                </div>
                <div class="col-sm-4">
                    <label>twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" required
                           value="{{$listSocialLinks[1]}}">
                </div>
                <div class="col-sm-4">
                    <label>instagram</label>
                    <input type="text" class="form-control" id="instagram" name="instagram" required
                           value="{{$listSocialLinks[2]}}">
                </div>
                <div class="col-sm-4">
                    <label>zalo</label>
                    <input type="text" class="form-control" id="zalo" name="zalo" required
                           value="{{$listSocialLinks[3]}}">
                </div>
                <div class="col-sm-4">
                    <label>kakao</label>
                    <input type="text" class="form-control" id="kakao" name="kakao" required
                           value="{{$listSocialLinks[4]}}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
        </form>
    @endif
@endsection
