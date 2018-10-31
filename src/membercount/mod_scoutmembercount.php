<?php

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$helper = new ModScoutMemberCountHelper($params);

$totalCount = $helper->getTotalCount();
$leaderCount = $helper->getLeaderCount();
$functionCount = $helper->getFunctionCount();
$showNewRegistered = $helper->getShowNewRegistered();
$newRegisteredCount = $helper->getNewRegisteredCount();
$newRegisteredInterval = $helper->getNewRegisteredInterval();
$stats = $helper->getStats();

require JModuleHelper::getLayoutPath('mod_scoutmembercount');