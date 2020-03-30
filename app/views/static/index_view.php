<html>
<head>
	<title>
		<?echo (isset($title)) ? $title : 'Title';?>
	</title>
</head>
<body>
<div>
	<form method="get" action="">
		<input type="text" name="search" value="<?echo (isset($search)) ?
			$search :
			'';?>">
		<button type="submit">Search</button>
	</form>
</div>
<div>
    <?if (isset($articles)):?>
		<?foreach ($articles as $item):?>
			<?foreach ($item as $line):?>
				<?echo $line;?><br>
			<?endforeach?>
			<br>
		<?endforeach?>
	<?endif?>
</div>
</body>
</html>