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
 * @global array $subscriptionLinks
 * @global Page $page
 * @global WireDateTime $datetime
 */


?>


<?php if(!$feeds->count()) : ?>
	<div class="uk-card uk-card-primary uk-margin">
		<div>
			<div class="uk-card-body uk-text-lead uk-text-muted uk-padding-small uk-text-center">
				<?= __('Add a podcast feed'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach($feeds as $feed) :
	$updateUrl = $page->url . 'update/' . $feed->id . '/';
	$deleteUrl = $page->url . 'delete/' . $feed->id . '/';

	if(count($subscriptionLinks)) {

		/** @var InputfieldForm $subscriptionLinksform */
		$subscriptionLinksform = $modules->get('InputfieldForm');

		/** @var InputfieldFieldset $subscriptionLinksFieldset */
		$subscriptionLinksFieldset = $modules->get('InputfieldFieldset');
		$subscriptionLinksFieldset->skipLabel = Inputfield::collapsedBlank;
		$subscriptionLinksFieldset->addClass('InputfieldIsClear');
		$subscriptionLinksFieldset->set('contentClass', 'uk-padding-remove');
		$subscriptionLinksFieldset->themeBorder = 'none';

		// Url fields
		foreach($subscriptionLinks as $name => $label) {
			$value = $feed->meta && $feed->meta->subscriptionLinks && property_exists($feed->meta->subscriptionLinks, $name)
				? $feed->meta->subscriptionLinks->{$name}
				: ''
				;


			$subscriptionLinksFieldset->add([
				'type' => 'Url',
				'name' => $name,
				'label' => $label,
				'value' => $value,
				'placeholder' => 'https://...',
				'noRelative' => true,
				'useLanguages' => false,
				'wrapClass' => 'InputfieldNoBorder',
				'headerClass' => 'uk-padding-remove-top',
				'columnWidth' => 50,
				'collapsed' => Inputfield::collapsedNever,
			]);
		}

		// feed ID
		$subscriptionLinksFieldset->add([
			'type' => 'Hidden',
			'name' => 'feedId',
			'value' => $feed->id
		]);

		// Add fieldset
		$subscriptionLinksform->add($subscriptionLinksFieldset);

		// Save
		$subscriptionLinksform->add([
			'type' => 'Submit',
			'name' => 'feedmeta',
			'columnWidth' => 100,
			'wrapClass' => 'uk-child-width-1-2',
			'value' => __('Save changes')
		]);

	}

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
			<div class="uk-card-body uk-padding-remove-bottom">
				<h3 class="uk-card-title uk-margin-remove-bottom"><?= $feed->title; ?></h3>
				<p class="uk-text-small uk-text-muted uk-margin-remove-top"><?= $feed['feed_url']; ?></p>
				<p><?= $feed->description; ?></p>
				<?php if(isset($subscriptionLinksform) && $subscriptionLinksform instanceof InputfieldForm) : ?>
					<div id="subscription-links-<?= $feed->id; ?>" hidden><?= $subscriptionLinksform->render(); ?></div>
				<?php endif; ?>
			</div>
			<div class="uk-card-footer uk-margin-top">
				<span class="uk-badge uk-padding-small uk-background-secondary uk-text-emphasis"><?= sprintf(__('%s Episodes'), $feed->media_count); ?></span>
				<span class="uk-badge uk-padding-small uk-background-secondary uk-text-emphasis"><?= sprintf(__('Updated: %s'), $datetime->relativeTimeStr($feed->modified)); ?></span>
				<?php if(isset($subscriptionLinksform) && $subscriptionLinksform instanceof InputfieldForm) : ?>
					<span uk-toggle="target: #subscription-links-<?= $feed->id; ?>; animation: uk-animation-fade" class="uk-button uk-button-text uk-align-right"><?= _x('Subscription links', 'Button'); ?></span>
				<?php endif; ?>
				<a href="<?= $updateUrl; ?>" title="<?= __('Update this feed'); ?>" class="uk-button uk-button-text uk-align-right"><?= _x('Update', 'Button'); ?></a>
				<a href="<?= $deleteUrl; ?>" title="<?= __('Delete this feed'); ?>" class="uk-button uk-button-text uk-align-right"><?= _x('Delete', 'Button'); ?></a>
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
