<!DOCTYPE html>
<html>
<head>
<title>
Show Me Image/Show me Article
</title>
</head>
<body>

<form method="post" action="/">
Image url:
<p>
<input type="text" name="image_url" size="100"/>
<p>
<input type="submit" value="Show Me Image!"/>
</form>

<form method="post" action="/url" target="_blank">
Article url:
<p>
<input type="text" name="article_url" size="100"/>
<p>
<input type="submit" value="Show Me Article!"/>
</form>

</body>
</html>