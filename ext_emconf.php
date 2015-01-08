<?php
########################################################################
# Extension Manager/Repository config file for ext "staticpub_pageexort".
#
# Auto generated 25-11-2011 13:34
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'staticpub_pageexort',
	'description' => 'Export pages (as ZIP-file) via staticpub',
	'category' => 'be',
	'author' => '',
	'author_email' => 'dev@aoe.com',
	'author_company' => 'AOE GmbH',
	'shy' => '',
	'dependencies' => 'extbase,staticpub,crawler',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0',
			'php' => '5.2.0',
			'extbase' => '1.2.1',
			'staticpub' => '',
			'crawler' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => '',
);
?>
