<html>
<head>
  <title>{{$post->title}}</title>
</head>
<body>
  <div>
    <h1>{{$post->title}}</h1>
    <h2>Scritto da {{$post->author->name}}</h2>
    <p>{{$post->content}}</p>
  </div>
</body>
</html>
