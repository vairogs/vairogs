<?php declare(strict_types = 1);

namespace Vairogs\Addon\Auth\OpenID\Steam\Model;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Stringable;
use Vairogs\Addon\Auth\OpenID\Steam\Contracts\User;
use Vairogs\Component\Auth\OpenID\Contracts\OpenIDUser;

/**
 * @ORM\MappedSuperclass()
 */
class Steam implements OpenIDUser, User, Stringable
{
    /**
     * @var bool
     */
    public const RETURNS_EMAIL = false;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $openID;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $communityState;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $profileState;

    /**
     * @ORM\Column(type="string")
     */
    protected string $persona;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $commentPermission;

    /**
     * @ORM\Column(type="string")
     */
    protected string $url;

    /**
     * @ORM\Column(type="array")
     */
    protected array $avatar;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $personaState;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $logoff = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $name = null;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected ?int $clanId = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected int $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected int $personaFlags;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $countryCode = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $stateCode = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $playing = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $playingId = null;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected ?string $username = null;

    /**
     * @return string
     */
    #[Pure] public function __toString(): string
    {
        return $this->getOpenID();
    }

    /**
     * @return string
     */
    public function getOpenID(): string
    {
        return $this->openID;
    }

    /**
     * @param string $openId
     *
     * @return User
     */
    public function setOpenID(string $openId): User
    {
        $this->openID = $openId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaying(): ?string
    {
        return $this->playing;
    }

    /**
     * @param string|null $playing
     *
     * @return User
     */
    public function setPlaying(?string $playing): User
    {
        $this->playing = $playing;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlayingId(): ?int
    {
        return $this->playingId;
    }

    /**
     * @param int|null $playingId
     *
     * @return User
     */
    public function setPlayingId(?int $playingId): User
    {
        $this->playingId = $playingId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCommunityState(): int
    {
        return $this->communityState;
    }

    /**
     * @param int $communityState
     *
     * @return User
     */
    public function setCommunityState(int $communityState): User
    {
        $this->communityState = $communityState;

        return $this;
    }

    /**
     * @return int
     */
    public function getProfileState(): int
    {
        return $this->profileState;
    }

    /**
     * @param int $profileState
     *
     * @return User
     */
    public function setProfileState(int $profileState): User
    {
        $this->profileState = $profileState;

        return $this;
    }

    /**
     * @return string
     */
    public function getPersona(): string
    {
        return $this->persona;
    }

    /**
     * @param string $persona
     *
     * @return User
     */
    public function setPersona(string $persona): User
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * @return int
     */
    public function getCommentPermission(): int
    {
        return $this->commentPermission;
    }

    /**
     * @param int $commentPermission
     *
     * @return User
     */
    public function setCommentPermission(int $commentPermission): User
    {
        $this->commentPermission = $commentPermission;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return User
     */
    public function setUrl(string $url): User
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvatar(): array
    {
        return $this->avatar;
    }

    /**
     * @param array $avatar
     *
     * @return User
     */
    public function setAvatar(array $avatar): User
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLogoff(): ?int
    {
        return $this->logoff;
    }

    /**
     * @param int|null $logoff
     *
     * @return User
     */
    public function setLogoff(?int $logoff): User
    {
        $this->logoff = $logoff;

        return $this;
    }

    /**
     * @return int
     */
    public function getPersonaState(): int
    {
        return $this->personaState;
    }

    /**
     * @param int $personaState
     *
     * @return User
     */
    public function setPersonaState(int $personaState): User
    {
        $this->personaState = $personaState;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return User
     */
    public function setName(?string $name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getClanId(): ?int
    {
        return $this->clanId;
    }

    /**
     * @param int|null $clanId
     *
     * @return User
     */
    public function setClanId(?int $clanId): User
    {
        $this->clanId = $clanId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     *
     * @return User
     */
    public function setCreatedAt(int $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getPersonaFlags(): int
    {
        return $this->personaFlags;
    }

    /**
     * @param int $personaFlags
     *
     * @return User
     */
    public function setPersonaFlags(int $personaFlags): User
    {
        $this->personaFlags = $personaFlags;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     *
     * @return User
     */
    public function setCountryCode(?string $countryCode): User
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStateCode(): ?int
    {
        return $this->stateCode;
    }

    /**
     * @param int|null $stateCode
     *
     * @return User
     */
    public function setStateCode(?int $stateCode): User
    {
        $this->stateCode = $stateCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function returnsEmail(): bool
    {
        return self::RETURNS_EMAIL;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return Steam
     */
    public function setUsername(?string $username): Steam
    {
        $this->username = $username;

        return $this;
    }
}
