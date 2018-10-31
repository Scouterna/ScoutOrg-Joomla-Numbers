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
    
    // OVERVIEW

    public function getShowOverview() {
        return boolval($this->params->get('showOverview'));
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

    public function getOfficerCount() {
        $count = 0;
        foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
            if (count($member->getRoleGroups()) > 0) {
                $count++;
            }
        }
        return $count;
    }

    // SCOUT TABLE

    public function getShowScoutTable() {
        return boolval($this->params->get('showScoutTable'));
    }

    public function getStats() {
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
            if ($year < $oldestYear + 3) {
                $currentStats->color = '#eC0e6e';
            } else if ($year < $oldestYear + 6) {
                $currentStats->color = '#e55300';
            } else if ($year < $oldestYear + 8) {
                $currentStats->color = '#00a2e1';
            } else if ($year < $oldestYear + 10) {
                $currentStats->color = '#12ad2b';
            } else {
                $currentStats->color = '#111111';
            }
            foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
                $dateOfBirth = new DateTime($member->getPersonInfo()->getDateOfBirth());
                $yearOfBirth = intval($dateOfBirth->format('Y'));
                if ($yearOfBirth == $year) {
                    $currentStats->scouts++;
                }
            }
            $stats[] = $currentStats;
        }

        return $stats;
    }

    // NEW MEMBERS

    public function getShowNewMembers() {
        return boolval($this->params->get('showNewMembers'));
    }

    public function getNewMembersInterval() {
        return intval($this->params->get('newMembersInterval'));
    }

    public function getNewMembersCount() {
        $interval = $this->params->get('newMembersInterval');
        $timePeriod = new DateInterval("P{$interval}D");
        $timestampLimit = (new DateTime())->sub($timePeriod)->getTimestamp();
        $amountNewMembers = 0;
        foreach ($this->scoutOrg->getScoutGroup()->getMembers() as $member) {
            $memberStartDate = new DateTime($member->getStartdate());
            if ($memberStartDate->getTimestamp() > $timestampLimit) {
                $amountNewMembers++;
            }
        }
        return $amountNewMembers;
    }
}