<?php

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$helper = new ModScoutWaitingCountHelper($params);

require JModuleHelper::getLayoutPath('mod_scoutwaitingcount');