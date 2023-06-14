<?php

namespace ProcessWire;

/**
 * @global Page $page
 * @global Pages $pages
 * @global WireDateTime $datetime
 * @global Config $config
 * @global Modules $modules
 */

?>

<!-- UIkit -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.8/dist/css/uikit.min.css" />
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.8/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.8/dist/js/uikit-icons.min.js"></script>

<?php
/** @var ProcessPodcastSubscriptions $podcastSubscription */
$podcastSubscription = $modules->getModule('ProcessPodcastSubscriptions', ['noPermissionCheck' => true]);
?>

<?php foreach($podcastSubscription->getFeeds('sort=-modified') as $feed) :
	$episodes = $pages->find('template=podcast-episode, sort=-created, podcast_feed=' . $feed->feed_url);
	?>

	<div class="uk-card uk-card-default uk-grid-collapse uk-margin" uk-grid>

		<div class="uk-card-media-left uk-padding uk-width-1-3@s uk-width-1-4@l">
			<div class="uk-width-auto">
				<?php if($feed->artwork_url) : ?>
					<img class="uk-border-rounded" src="<?= $feed->artwork_url; ?>" alt=""">
				<?php else : ?>
					<div class="uk-background-muted uk-border-rounded" style="padding-bottom: 100%"></div>
				<?php endif; ?>
			</div>
		</div>

		<div class="uk-width-2-3@s uk-width-3-4@l">
			<div class="uk-card-body">

				<!-- Title -->
				<h2 class="uk-card-title_ uk-text-bold uk-heading-small"><?= $feed->title; ?></h2>

				<!-- Description -->
				<p style="max-width: 820px"><?= $feed->description; ?></p>


				<div class="uk-inline">

					<!-- Subscribe buttons -->
					<?php if($feed->meta->subscriptionLinks ?? false && count((array) $feed->meta->subscriptionLinks)) : ?>

					<!-- Subscribe -->
					<button class="uk-button uk-button-default uk-margin-right" uk-icon="chevron-down" type="button">
						<?= __('Subscribe'); ?>
					</button>
					<div uk-dropdown>
						<ul class="uk-nav uk-dropdown-nav">
							<?php foreach($podcastSubscription->subscriptionLinks as $name => $label) :
								if(!property_exists($feed->meta->subscriptionLinks, $name)) continue;
								$url = $feed->meta->subscriptionLinks->{$name};
								?>
								<li><a
										class=""
										href="<?= $url; ?>"
										rel="noopener"
										target="_blank"
							><?= $label; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>

					<?php endif; ?>

					<!-- Episodes -->
					<button class="uk-button uk-button-link uk-margin-right" disabled>
						<?= sprintf(__('%s Episodes'), $feed->media_count); ?>
					</button>

					<!-- Last update -->
					<button class="uk-button uk-button-link uk-margin-right" disabled>
						<?= sprintf(__('Updated: %s'), $datetime->relativeTimeStr($feed->modified)); ?>
					</button>
				</div>


			</div>

			<div class="uk-card-footer">
				<h3 class="uk-text-large uk-text-muted">Episodes</h3>
				<ul uk-accordion class="uk-margin-bottom">
					<?php foreach($episodes as $episode) : ?>

						<li>
							<a class="uk-accordion-title" href="#">
								<div class="uk-flex uk-flex-between" style="gap:10px">
									<span>
										<?= $episode->title; ?>
										<time
											class="uk-text-muted"
											style="white-space: nowrap"
											datetime="<?= $datetime->formatDate($episode->created, 'c'); ?>"
										>
											—
											<?= $episode->created + (86400 * 3) > time()
												? $datetime->relativeTimeStr($episode->created, true)
												: $datetime->formatDate($episode->created, '%e. %h %Y'); ?>
										</time>
									</span>
									<span style="white-space: nowrap"><?= sprintf(__('%d min.'), round((int)$episode->episode_duration/60, 0)); ?></span>
								</div>

							</a>
							<div class="uk-accordion-content">

								<?php if($episode->episode_number) : ?>
									<p><span class="uk-label"><?= sprintf(__('Episode #%s'), $episode->episode_number); ?></span></p>
								<?php endif; ?>

								<p><?= $episode->episode_description; ?></p>
								<p><audio controls preload="none" src="<?= $episode->episode_media; ?>"></audio></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

	</div>

<?php endforeach; ?>
