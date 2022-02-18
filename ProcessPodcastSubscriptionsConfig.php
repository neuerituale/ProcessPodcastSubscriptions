<?php
/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2021 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;


class ProcessPodcastSubscriptionsConfig extends ModuleConfig
{
	/**
	 * @return array
	 * @throws WireException
	 */
	public function getDefaults() {

		// get schedules from Lazy Cron
		$lazyCronInstance = $this->modules->get('LazyCron');
		$getTimeFuncsFunction = function(){ return $this->timeFuncs; };

		return [
			'cronSchedule' => 300,
			'timeFuncs' => $getTimeFuncsFunction->call($lazyCronInstance),
			'lastMaintenance' => 0
		];
	}

	/**
	 * @return InputfieldWrapper
	 * @throws WireException
	 * @throws WirePermissionException
	 */
	public function getInputfields() {

		$inputfields = parent::getInputfields();

		/** @var InputfieldSelect */
		$inputfields->add([
			'type' => 'Select',
			'name' => 'cronSchedule',
			'label' => __('Cron Schedule'),
			'description' => __('If selected, the cron will check all action from selected fields.'),
			'options' => $this->get('timeFuncs'),
			'columnWidth' => 33,
		]);

		return $inputfields;
	}
}