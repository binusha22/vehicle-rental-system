<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  
</head>
<body>
  <h1>Pusher Test</h1>
  <form action="{{route('push')}}" method="post">
    @csrf
    <input type="text" name="name" id="">
    <button type="submit">sum</button>
  </form>
</body>
</html>