<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=620, initial-scale=1" />
		<meta name="format-detection" content="telephone=no"/>

		<title><?=$title;?></title>

		<meta name="description" content="<?=$description;?>">
		<meta name="keywords" content="<?=$keywords;?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?if($fbShare["share"] == true):?>
			<meta property="og:site_name" content="<?=$fbShare["siteName"];?>">
			<meta property="og:title" content="<?=$fbShare["title"];?>">
			<meta property="og:description" content="<?=$fbShare["share"];?>">
			<meta property="og:image" content="<?=$fbShare["share"];?>">
		<?endif;?>

		<!--<script src="//use.typekit.net/eyj0xst.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>-->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52ea88da20eba08e"></script>

        <?=\Fuel\Core\Asset::css($css);?>
    </head>
    <body>
        <div id="header"><?=\Fuel\Core\View::forge($header);?></div>
        <div id="container" class="clearfix">
            <?=$content;?>
			<div id="footer-push"></div>
        </div>
        <div id="footer" class="clearfix"><?=\Fuel\Core\View::forge($footer, $footer_options);?></div>

        <?=htmlspecialchars_decode($jsVars->generateOutput());?>

		<?=\Fuel\Core\Asset::js($js);?>
	</body>
</html>
