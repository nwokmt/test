@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>注文一覧</h1>

        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="20%">発注日時</th>
                                <th width="20%">発注者</th>
                                <th width="10%">商品</th>
                                <th width="40%">金額</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($orders as $order)
                                <tr>
                                    <td>{{ ($order->created_at) }}</td>
                                    <td>{{ ($order->name) }}</td>
<td>
                                    @foreach($order->details as $detail)
@if(empty($item->image))
                                <img src="/img/noimg.png" id="image_thum" width="150">
@else
                                  <img src="{{ $item->image }}" id="image_thum" width="150">
@endif
                                    @endforeach

</td>
                                    <td>{{ ($item->price) }}円</td>
                                    <td>{{ ($item->description) }}</td>
				    <td align="center">
 					<a class="btn btn-primary" href="{{ action('Admin\ItemController@detail', ['id' => $item->id]) }}">詳細</a><br><br>
 					<a class="btn btn-primary" href="{{ action('Admin\ItemController@edit', ['id' => $item->id]) }}">編集</a>
                                        
                                    </td>
                                </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection