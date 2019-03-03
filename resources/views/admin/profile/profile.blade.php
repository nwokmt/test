@extends('layouts.app')
<script src="/js/jquery-2.2.0.js"></script>
<script src="/js/jquery.Jcrop.js"></script>
<script src="/js/Jcrop.js"></script>
<script src="/js/rotate.js"></script>
<link rel="stylesheet" type="text/css" href="/css/Jcrop.css"/>

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
<!------ img ------>
<label class="verify_person__formbox__item_profile-img-upload" id="photo_frame1">
<input type="file" accept="image/*" id="fileData1" class="fileData">
<div id="description1">
			@if (old('image'))
<img src="{{ old('image') }}" id="image_thum" width="150">
            @else
<img src="/img/noimg.png" id="image_thum" width="150">
			@endif
<input type="hidden" name="image" id="image_src" value="{{ old('image') }}">
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

<div id="modal">
 
<div id="open01">
<a href="#" class="close_overlay">×</a>
<div class="modal_window">
<h2>切り取り</h2>
<a href="javascript:void(0);" id="btnCrop"  class="modal-close"> 切り取る</a>　<a href="#">閉じる</a><br>
<img src="./img/noimg.png" id="jcrop_target">
<!- サムネイル ->
<div class="inline-labels" style="display:none;">
<img id="thumb">
<br>
    <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
    <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
    <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
    <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
    <label>W <input type="text" size="4" id="w" name="w" /></label>
    <label>H <input type="text" size="4" id="h" name="h" /></label>
</div><!-- display:none -->
</div>
<br>
</div><!--/.modal_window-->
</div><!--/#open01-->

</div><!--/#modal-->

@endsection