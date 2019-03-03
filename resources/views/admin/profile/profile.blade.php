@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>プロフィール編集</h1>
                <form action="{{ action('Admin\ProfileController@edit') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="row justify-content-center">
                    <div class="col-lg-8">
                    <div class="card">
                    <div class="card-body">
                      <div class="form-group row">
                          <label class="col-md-2" for="name">名前</label>
                              <div class="col-md-6">
                              <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                          </div>
                      </div>
                          <div class="form-group row">
                              <label class="col-md-2" for="introduction">自己紹介欄</label>
                              <div class="col-md-9">
                                  <textarea class="form-control" name="introduction" rows="8">{{ old('introduction') }}</textarea>
                              </div>
                         </div>
                         <div class="form-group row">
                             <label class="col-md-2" for="image">画像</label>
                             <div class="col-md-8">
                                 <input type="file" class="form-control-file" name="image">

<!------ img ------>
<label class="verify_person__formbox__item_profile-img-upload" id="photo_frame1">
<input type="file" accept="image/*" id="fileData1" class="fileData">
<div id="description1">
			@if (old('image'))
<img src="{{ old('image') }}" id="image_thum" width="150">
            @else
<img src="/img/noimg.png" id="image_thum" width="150">
			@endif
<input type="hidden" name="image_src" id="image_src" value="{{ old('image') }}">
</div>
</label>
<!------ img ------>
                             </div>
                         </div>
                         {{ csrf_field() }}
                         <div class="row justify-content-center">
                         <input type="submit" class="btn btn-warning" value="更新">
                         </div>
                    </div>
                    </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection