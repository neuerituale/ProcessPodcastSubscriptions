<?php
/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2022 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;

class ProcessPodcastSubscriptionsEpisodesConfig extends ModuleConfig
{
	/**
	 * @return array
	 * @throws WireException
	 */
	public function getDefaults() {

		return [
			'episodeParentId' => 1
		];
	}

	/**
	 * @return InputfieldWrapper
	 * @throws WireException
	 * @throws WirePermissionException
	 */
	public function getInputfields() {

		$inputfields = parent::getInputfields();

		/** @var InputfieldPage */
		$inputfields->add([
			'type' => 'PageListSelect',
			'name' => 'episodeParentId',
			'label' => 'Parent for new episode pages',
			'allowUnpub' => true,

			'collapsed' => Inputfield::collapsedNever,
			'columnWidth' => 100,
		]);

		return $inputfields;
	}
}