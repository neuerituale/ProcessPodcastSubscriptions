<?php

namespace ProcessWire;

/**
 * @global Page $page
 * @global Pages $pages
 * @global Config $config
 */

function secondsToTime($iSeconds)
{
	$min = intval($iSeconds / 60);
	return $min . ':' . str_pad(($iSeconds % 60), 2, '0', STR_PAD_LEFT);
}


?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page->title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates?>styles/main.css" />
	</head>
	<body>

		<div style="display: flex; padding: 1rem; max-width: 900px; margin: auto">

			<div style="flex:1;">
				<figure>
					<img
						src="<?= $page->episode_image->url; ?>"
						width="<?= $page->episode_image->width; ?>"
						height="<?= $page->episode_image->height; ?>"
						alt="<?= $page->episode_image->description; ?>"
						style="max-width: 100%; height: auto;"
						>
				</figure>
			</div>

			<div style="flex:2;">
				<h1><?php echo $page->title; ?></h1>

				<p><?= $page->episode_description; ?></p>

				<p><strong>Duration: <?= secondsToTime($page->episode_duration); ?></strong></p>
				<audio controls src="<?= $page->episode_media; ?>"> </audio>

				<br><br><hr>

				<h2>More Episodes</h2>
				<ul>
				<?php foreach($pages->find("podcast_feed={$page->podcast_feed}, sort=-published") as $episode) : ?>
					<li>
						<a
							href="<?= $episode->url; ?>"
							title="<?= $episode->title; ?>"
							style="display: flex; justify-content: space-between;"
						>
							<span><?= $episode->title; ?></span>
							<span><?= secondsToTime($episode->episode_duration); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>

		</div>

		<?php if($page->editable()) echo "<p><a href='$page->editURL'>Edit</a></p>"; ?>
	
	</body>
</html>
