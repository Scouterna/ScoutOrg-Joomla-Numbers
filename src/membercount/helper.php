<?php

class ModScoutMemberCountHelper {
    /** @var mixed */
    private $params;

    /** @var Org\Lib\ScoutOrg */
    private $scoutOrg;

    /**
     * Creates a new helper
     * @param mixed $params
     */
    public function __construct($params) {
        jimport('scoutorg.loader');
        $this->scoutOrg = ScoutOrgLoader::load();
        $this->params = $params;
    }
    
    public function getTotalCount() {
        return count($this->scoutOrg->getScoutGroup()->getMembers());
    }

    public function getLeaderCount() {
        $count = 0;
        foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
            if ($this->isLeader($member)) {
                $count++;
            }
        }
        return $count;
    }

    private function isLeader(Org\Lib\Member $member) {
        foreach($member->getTroops() as $troop) {
            if (isset($troop->getMemberRoles()[$member->getId()])) {
                return true;
            }
        }
        return false;
    }

    public function getFunctionCount() {
        $count = 0;
        foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
            if (count($member->getRoleGroups()) > 0) {
                $count++;
            }
        }
        return $count;
    }

    public function getShowNewRegistered() {
        return boolval($this->params->get('showNewRegistered'));
    }

    public function getNewRegisteredInterval() {
        return intval($this->params->get('newRegisteredInterval'));
    }

    public function getNewRegisteredCount() {
        $interval = $this->params->get('newRegisteredInterval');
        $timePeriod = new DateInterval("P{$interval}D");
        $timestampLimit = (new DateTime())->sub($timePeriod)->getTimestamp();
        $amountNewRegistered = 0;
        foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
            $memberStartDate = new DateTime($member->getStartdate());
            if ($memberStartDate->getTimestamp() > $timestampLimit) {
                $amountNewRegistered++;
            }
        }
        return $amountNewRegistered;
    }

    public static function getStats() {
        // August - 7 = January (8 - 7 = 1), August = first month, July = last month
        $currentYear = intval((new \DateTime())->sub(new \DateInterval('P7M'))->format('Y'));
        $oldestYear = $currentYear - 17;

        $stats = [];
        foreach (range($oldestYear, $currentYear - 7) as $year) {
            $currentStats = (object)[
                'year' => $year,
                'scouts' => 0,
                'color' => '',
            ];
            foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
                $dateOfBirth = new DateTime($member->getPersonInfo()->getDateOfBirth());
                $yearOfBirth = intval($dateOfBirth->format('Y'));
                if ($yearOfBirth == $year) {
                    $currentStats->scouts++;
                }
                if ($yearOfBirth < $oldestYear + 3) {
                    $currentStats->color = '#eC0e6e';
                } else if ($yearOfBirth < $oldestYear + 6) {
                    $currentStats->color = '#e55300';
                } else if ($yearOfBirth < $oldestYear + 8) {
                    $currentStats->color = '#00a2e1';
                } else if ($yearOfBirth < $oldestYear + 10) {
                    $currentStats->color = '#12ad2b';
                } else {
                    $currentStats->color = '#111111';
                }
            }
            $stats[] = $currentStats;
        }

        return $stats;
    }
}