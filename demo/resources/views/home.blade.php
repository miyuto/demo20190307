<h3>Nhập số cần chuyển đổi:</h3>
<form action="{{ route('post-cal') }}" method="post">
    @csrf
    <input type="text" name="number">

<select name="numberlist" >
    <option value="2">2</option>
    <option value="10">10</option>
    <option value="16">16</option>
</select>
    <input type="submit" value="Convert">
</form>
<br>
@if(Session::has('result'))
    <div>{{ Session::get('result') }}</div>
@endif