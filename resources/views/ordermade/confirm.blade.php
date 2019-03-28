@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>注文内容</h1>
                <form action="{{ action('OrderController@save') }}" method="post" enctype="multipart/form-data">

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
                          <label class="col-md-2" for="name">種類</label>
                              <div class="col-md-6">
                              {{ $order->name }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2" for="name">素材</label>
                              <div class="col-md-6">
                              {{ $order->material }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2" for="name">色</label>
                              <div class="col-md-6">
                              {{ $order->color }}
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
                      <div class="form-group row">
                          <label class="col-md-2" for="name">支払い金額</label>
                              <div class="col-md-6">
                              {{ $total+ Config::get('const.postage')}}円　(　商品合計:{{ $total }}円＋送料：{{Config::get('const.postage')}}円　)
                          </div>
                      </div>

                             </div>
                         </div>
                         {{ csrf_field() }}
                         <div class="row justify-content-center">
                         <input type="submit" class="btn btn-warning" value="この内容で注文">
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