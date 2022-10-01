<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>youssef</h1>
    <form action="{{ route('one') }}" method="POst" enctype="multipart/form-data">
        <input type="file" name="filo">
        @csrf
        <button type="submit">go</button>
    </form>
</body>

</html>;
