@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>注文内容</h1>
                <form action="{{ action('OrderController@confirm') }}" method="post" enctype="multipart/form-data">

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
                              {{ $order->name }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2" for="name">郵便番号</label>
                              <div class="col-md-6">
                              {{ $order->postalcode }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2" for="name">住所</label>
                              <div class="col-md-6">
                              {{ $order->address }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2" for="name">支払い方法</label>
                              <div class="col-md-6">
                              {{ $order->payment }}
                          </div>
                      </div>

<!-- カート--->

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="5">注文商品</th>
                            </tr>
                            <tr>
                                <th width="20%">画像</th>
                                <th width="20%">商品名</th>
                                <th width="10%">金額</th>
                                <th width="40%">説明</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($items as $key=>$item)
                                <tr>
<td>
@if(empty($item->image))
                                <img src="/img/noimg.png" id="image_thum" width="150">
@else
                                  <img src="{{ $item->image }}" id="image_thum" width="150">
@endif
</td>
                                    <td>{{ ($item->name) }}</td>
                                    <td>{{ ($item->price) }}円</td>
                                    <td>{{ ($item->description) }}</td>
				    <td align="center">
 					<a class="btn btn-primary" href="{{ action('OrderController@detail', ['id' => $item->id]) }}">詳細</a><br><br>
 					<a class="btn btn-primary" href="{{ action('OrderController@remove', ['id' => $key]) }}">削除</a>
                                        
                                    </td>
                                </tr>
                             @endforeach
                        </tbody>
                    </table>

                             </div>
                         </div>
                         {{ csrf_field() }}
                         <div class="row justify-content-center">
                         <input type="submit" class="btn btn-warning" value="注文内容確認">
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