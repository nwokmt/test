@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>商品一覧</h1>

        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="10%">場所</th>
                                <th width="10%">店名</th>
                                <th width="30%">コメント</th>
				<th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($items as $item)
                                <tr>
@if(empty($item->image))
                                <img src="/img/noimg.png" id="image_thum" width="150">
@else
                                  <img src="{{ $item->image }}" id="image_thum" width="150">
@endif
                                    <td>{{ ($item->name) }}</td>
                                    <td>{{  ($item->price) }}円</td>
                                    <td>{{ str_limit($item->description) }}</td>
				    <td align="center">
 					<a class="btn btn-primary" href="{{ action('Admin\ItemController@detail', ['id' => $item->id]) }}">詳細</a>
                                        
                                    </td>
                                </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


                <form action="{{ action('Admin\ItemController@save') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif

@if (empty($item))
                              <input type="hidden" class="form-control" name="name" value="">
@else
                              <input type="hidden" class="form-control" name="name" value="{{ old('id',$item->id) }}">
@endif
                    <div class="row justify-content-center">
                    <div class="col-lg-8">
                    <div class="card">
                    <div class="card-body">
                      <div class="form-group row">
                          <label class="col-md-2" for="name">商品名</label>
                              <div class="col-md-6">
                              <input type="text" class="form-control" name="name" value="{{ old('name',$item->name) }}">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2" for="name">金額</label>
                              <div class="col-md-6">
                              <input type="number" class="form-control" name="price" value="{{ old('name',$item->price) }}">円
                          </div>
                      </div>
                          <div class="form-group row">
                              <label class="col-md-2" for="introduction">説明</label>
                              <div class="col-md-9">
                                <textarea class="form-control" name="description" rows="8">{{ old('description',$item->description) }}</textarea>
                              </div>
                         </div>
                         <div class="form-group row">
                             <label class="col-md-2" for="image">画像</label>
                             <div class="col-md-8">
<!------ img ------>
<label class="verify_person__formbox__item_profile-img-upload" id="photo_frame1">
<input type="file" accept="image/*" class="fileData">
<div id="description1">
			@if (old('image'))
@if (empty($item))
                <img src="{{ old('image') }}" id="image_thum" width="150">
                <input type="hidden" name="image" id="image_src" value="{{ old('image') }}">
@else
                <img src="{{ old('image',$item->image) }}" id="image_thum" width="150">
                <input type="hidden" name="image" id="image_src" value="{{ old('image',$item->image) }}">
@endif
            @else

@if (empty($item))
                <img src="/img/noimg.png" id="image_thum" width="150">
                <input type="hidden" name="image" id="image_src" value="{{ old('image') }}">
@else
                <img src="{{ $item->image }}" id="image_thum" width="150">
                <input type="hidden" name="image" id="image_src" value="{{ old('image',$item->image) }}">
@endif
			@endif
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