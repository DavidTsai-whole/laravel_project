@extends('layout.app')
@section('content')
<h3>聯絡我們</h3>
<form class="w-50" action="">
<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">請問你是: </label>
    <input type="text" class="form-control" id="exampleInputPassword1">
</div>
<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">請問你的消費時間: </label>
    <input type="date" class="form-control" id="exampleInputPassword1">
</div>
<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">你消費的商品種類: </label>
    <select class="form-control" name="" id="">
    <option value="物品">物品</option>
    <option value="食物">食物</option>
    </select><br>
</div>

    <button class="btn btn-success">送出</button>
</form>
@endsection