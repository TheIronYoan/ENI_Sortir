<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $signInLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxUsers;

    /**
     * @ORM\Column(type="text")
     */
    private $description;



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="events")
     * @ORM\JoinTable(
     *  name="user_event",
     *  joinColumns={
     *      @ORM\JoinColumn(name="events_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  }
     * )
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="organizedEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organizer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="event")
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventState", inversedBy="events")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="event")
     */
    private $location;

    public function __construct()
    {
        $this->state = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSignInLimit()
    {
        return $this->signInLimit;
    }

    public function setSignInLimit( $signInLimit): self
    {
        $this->signInLimit = $signInLimit;

        return $this;
    }

    public function getMaxUsers(): ?int
    {
        return $this->maxUsers;
    }

    public function setMaxUsers(int $maxUsers): self
    {
        $this->maxUsers = $maxUsers;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addEvent($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeEvent($this);
        }

        return $this;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function setOrganizer(User $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getCampus()
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState(?EventState $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
