<?php
/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2021 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;

/**
 * @global MarkupAdminDataTable $table
 * @global string $notes
 * @global string $actionField
 * @global array $actions
 * @global PageArray $actionPages
 * @global Modules $modules
 * @global WireArray $feeds
 * @global Page $page
 * @global WireDateTime $datetime
 */

?>


<?php if(!$feeds->count()) : ?>
	<div class="uk-card uk-card-primary uk-margin">
		<div>
			<div class="uk-card-body uk-text-lead uk-text-muted uk-padding-small uk-text-center">
				<?= __('Please add a podcast feed.'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach($feeds as $feed) :
	$updateUrl = $page->url . 'update/' . $feed->id . '/';
	$deleteUrl = $page->url . 'delete/' . $feed->id . '/';
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
				<h3 class="uk-card-title"><?= $feed->title; ?></h3>
				<p><?= $feed->description; ?></p>
			</div>
			<div class="uk-card-footer">
				<span class="uk-badge uk-padding-small"><?= sprintf(__('%s Episodes'), $feed->media_count); ?></span>
				<span class="uk-badge uk-padding-small uk-background-secondary uk-text-emphasis"><?= sprintf(__('Updated: %s'), $datetime->relativeTimeStr($feed->modified)); ?></span>

				<a href="<?= $updateUrl; ?>" title="<?= __('Update this feed'); ?>" class="uk-button uk-button-text uk-align-right"><?= __('Update'); ?></a>
				<a href="<?= $deleteUrl; ?>" title="<?= __('Delete this feed'); ?>" class="uk-button uk-button-text uk-align-right"><?= __('Delete'); ?></a>
			</div>
		</div>

	</div>

<?php endforeach; ?>

<?php
$form = $modules->get('InputfieldForm');

$form->add([
	'type' => 'url',
	'name' => 'feed_url',
	'label' => $this->_('Feed URL'),
	'notes' => $this->_('Podcast XML Feed ([Example](https://support.google.com/podcast-publishers/answer/9889544?hl=de#example_feed))'),
	'required' => true,
	'placeholder' => 'https://...',
	'noRelative' => true,
	'useLanguages' => false,
	'wrapClass' => 'InputfieldNoBorder',
	'collapsed' => Inputfield::collapsedNever,
]);

$form->add([
	'type' => 'submit',
	'name' => 'submit',
	'value' => __('Add Feed')
]);


?>
<div class="uk-card uk-card-default uk-margin">
	<div>
		<div class="uk-card-body">
			<?= $form->render(); ?>
		</div>
	</div>
</div>
