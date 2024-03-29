<?php
/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2023 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;

class ProcessPodcastSubscriptionsConfig extends ModuleConfig
{
	/**
	 * @return array
	 * @throws WireException
	 */
	public function getDefaults(): array {

		// get schedules from Lazy Cron
		$lazyCronInstance = $this->modules->get('LazyCron');
		$getTimeFuncsFunction = function(){ return $this->timeFuncs; };

		return [
			'cronSchedule' => 86400,
			'timeFuncs' => $getTimeFuncsFunction->call($lazyCronInstance),
			'lastMaintenance' => 0,
			'parent' => 1
		];
	}

	/**
	 * @return InputfieldWrapper
	 */
	public function getInputfields(): InputfieldWrapper {

		$inputfields = parent::getInputfields();

		/** @var InputfieldSelect */
		$inputfields->add([
			'type' => 'Select',
			'name' => 'cronSchedule',
			'label' => $this->_('Cron Schedule'),
			'description' => $this->_('If selected, the cron will updates all subscribed feeds.'),
			'options' => $this->get('timeFuncs'),
			'columnWidth' => 100,
		]);

		/** @var InputfieldSelect */
		$inputfields->add([
			'type' => 'Textarea',
			'name' => 'subscriptionLinksConfig',
			'label' => $this->_('Subscription Links'),
			'description' => $this->_('One per line name and label'),
			'notes' => $this->_('spotify=Spotify'),
			'columnWidth' => 100,
		]);

		return $inputfields;
	}
}