<?php

class ModScoutWaitingCountHelper {
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
        return count($this->scoutOrg->getWaitingList());
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
        $amountNewRegistered = 0;
        foreach ($this->scoutOrg->getWaitingList() as $waitingMember) {
            $memberStartDate = new DateTime($waitingMember->getWaitingStartdate());
            if ($memberStartDate->getTimestamp() > (new DateTime())->sub($timePeriod)->getTimestamp()) {
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
        foreach (range($oldestYear, $currentYear) as $year) {
            $currentStats = (object)[
                'year' => $year,
                'scouts' => 0,
                'leaders' => 0,
                'color' => '',
            ];
            foreach ($this->scoutOrg->getWaitingList() as $waitingMember) {
                $dateOfBirth = new DateTime($waitingMember->getPersonInfo()->getDateOfBirth());
                $yearOfBirth = intval($dateOfBirth->format('Y'));
                if ($yearOfBirth == $year) {
                    $currentStats->scouts++;
                    if ($waitingMember->hasLeaderInterest()) {
                        $currentStats->leaders++;
                    }
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