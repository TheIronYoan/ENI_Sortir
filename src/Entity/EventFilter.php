<?php


namespace App\Entity;


class EventFilter
{

    /**
     * @var string|null
     */
    private $searchZone;

    /**
     * @var City|null
     */
    private $city;

    /**
     * @var \DateTime|null
     */
    private $dateBegin;

    /**
     * @var \DateTime|null
     */
    private $dateEnd;

    /**
     * @var boolean
     */
    private $organizedEvent;

    /**
     * @var boolean
     */
    private $joinedEvent;

    /**
     * @var boolean
     */
    private $joinableEvent;

    /**
     * @var boolean
     */
    private $pastEvent;

    /**
     * @return string|null
     */
    public function getSearchZone()
    {
        return $this->searchZone;
    }

    /**
     * @param string $searchZone
     */
    public function setSearchZone($searchZone): void
    {
        $this->searchZone = $searchZone;
    }

    /**
     * @return City|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * @param \DateTime $dateBegin
     */
    public function setDateBegin($dateBegin): void
    {
        $this->dateBegin = $dateBegin;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd($dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return boolean
     */
    public function getOrganizedEvent()
    {
        return $this->organizedEvent;
    }

    /**
     * @param boolean $organizedEvent
     */
    public function setOrganizedEvent($organizedEvent): void
    {
        $this->organizedEvent = $organizedEvent;
    }

    /**
     * @return boolean
     */
    public function getJoinedEvent()
    {
        return $this->joinedEvent;
    }

    /**
     * @param boolean $joinedEvent
     */
    public function setJoinedEvent($joinedEvent): void
    {
        $this->joinedEvent = $joinedEvent;
    }

    /**
     * @return boolean
     */
    public function getJoinableEvent()
    {
        return $this->joinableEvent;
    }

    /**
     * @param boolean $joinableEvent
     */
    public function setJoinableEvent($joinableEvent): void
    {
        $this->joinableEvent = $joinableEvent;
    }

    /**
     * @return boolean
     */
    public function getPastEvent()
    {
        return $this->pastEvent;
    }

    /**
     * @param boolean $pastEvent
     */
    public function setPastEvent($pastEvent): void
    {
        $this->pastEvent = $pastEvent;
    }
}