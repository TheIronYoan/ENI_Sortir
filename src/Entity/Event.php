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
     * @ORM\OneToMany(targetEntity="App\Entity\EventState", mappedBy="event")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="event")
     */
    private $location;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="events")
     */
    private $campus;

    public function __construct()
    {
        $this->state = new ArrayCollection();
        $this->location = new ArrayCollection();
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
     * @return Collection|EventState[]
     */
    public function getState(): Collection
    {
        return $this->state;
    }

    public function addState(EventState $state): self
    {
        if (!$this->state->contains($state)) {
            $this->state[] = $state;
            $state->setEvent($this);
        }

        return $this;
    }

    public function removeState(EventState $state): self
    {
        if ($this->state->contains($state)) {
            $this->state->removeElement($state);
            // set the owning side to null (unless already changed)
            if ($state->getEvent() === $this) {
                $state->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
            $location->setEvent($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->location->contains($location)) {
            $this->location->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getEvent() === $this) {
                $location->setEvent(null);
            }
        }

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
}
