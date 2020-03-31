<html>
<head>
	<title>
		<?echo (isset($title)) ? $title : 'Title';?>
	</title>
</head>
<body>
<div>
	<form method="get" action="">
		<input required type="text" name="q" value="<?echo (isset($q)) ?	$q : '';?>">
		Language
		<select name="language">
			<option selected value='all'>all</option>
			<?if (isset($languages)):?>
				<?foreach ($languages as $_language):?>
					<option <?echo ($_language == $language)?'selected':'';?> value="<?echo $_language?>"><?echo $_language?></option>
				<?endforeach;?>
			<?endif;?>
		</select>
		<button type="submit">Search</button>
	</form>
</div>
<div>
    <?if (isset($articles)):?>
		<?foreach ($articles as $art):?>
			<h3><?echo $art['title'];?></h3>
			<h4><?echo $art['description'];?></h4>
			<h4><a href="<?echo $art['url'];?>"><?echo $art['url'];?></a></h4>
			<br>
		<?endforeach;?>
	<?endif;?>
</div>
</body>
</html>