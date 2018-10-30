<?php

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$helper = new ModScoutWaitingCountHelper($params);

$totalCount = $helper->getTotalCount();
$showNewRegistered = $helper->getShowNewRegistered();
$newRegisteredCount = $helper->getNewRegisteredCount();
$newRegisteredInterval = $helper->getNewRegisteredInterval();
$stats = $helper->getStats();

require JModuleHelper::getLayoutPath('mod_waitingcount');