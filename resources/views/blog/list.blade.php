<html>
  <head>
    <title>Lista dei post</title>
  </head>
<body>
  @if(count($posts)===0)
  <h1>Nessun post</h1>
  @endif
  @foreach ($posts as $post)
  <div>
    <h1><a href="/post/{{$post->id}}">{{$post->title}}</a></h1>
    <h2>Scritto da {{$post->author->name}}</h2>
    <p>{{$post->content}}</p>
  </div>
  @endforeach
</body>
</html>
