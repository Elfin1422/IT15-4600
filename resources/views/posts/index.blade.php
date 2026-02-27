<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
</head>
<body>
    <h1>Posts</h1>

    @foreach($posts as $post)
        <div style="margin-bottom:20px;">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            <hr>
        </div>
    @endforeach

</body>
</html>