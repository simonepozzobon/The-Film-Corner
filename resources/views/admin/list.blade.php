<html>
<head>
  <title>Admin Post List</title>
</head>
<body>

  <!-- Loop con i post -->
  @if(count($posts)===0)
    <h1>Non è presente alcun post</h1>
    <p>Creane subito uno</p>
  @endif
  <ul>
    @foreach ($posts as $post)
      <li>
        <h1>{{$post->title}}</h1>
      </li>
    @endforeach
  </ul>


</body>
</html>
