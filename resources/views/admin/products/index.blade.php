@extends('layout.admin_app')
@section('content')


<h2>產品列表</h2>
<span>產品總數: {{$productCount}}</span>
<div>
    <input  type="button" class="import btn btn-success" value="匯入 Excel">
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<table class="table">
    <thead>
        <tr>
            <td>編號</td>
            <td>標題</td>
            <td>內容</td>
            <td>價格</td>
            <td>數量</td>
            <td>圖片</td>
            <td>功能</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->title}}</td>
            <td>{{$product->content}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->quantity}}</td>
            <td><a href="{{$product->image_url}}">圖片連結</a></td>
            <td>
            <input  type="button" class="upload_image btn btn-danger" data-id="{{$product->id}}" value="上傳圖片">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
    @for ($i=1; $i <= $productPages; $i++)
    <li class="page-item"><a class="page-link" href="/admin/products?page={{$i}}">{{$i}}</a></li>

    @endfor
    </ul>
    </nav>

<script>
    $('.upload_image').click(function(){
        $('#product_id').val($(this).data('id'))
        $('#upload_image').modal()
    })

    $('.import').click(function(){
        $('#import').modal()
    })
</script>
@endsection