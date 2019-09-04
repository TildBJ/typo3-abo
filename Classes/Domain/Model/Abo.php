<?php
declare(strict_types=1);

namespace TildBJ\Abo\Domain\Model;

use TildBJ\Abo\Domain\Abo as AboInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Abo
 * @package TildBJ\Abo\Domain\Model
 */
class Abo extends AbstractEntity implements AboInterface
{
    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $hash = '';

    /**
     * Abo constructor.
     * @param string $email
     * @param string $hash
     */
    public function __construct(string $email)
    {
        $this->email = $email;
        $this->hash = \TildBJ\Abo\Utility\GeneralUtility::generateRandomString();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return bool
     */
    public function confirm(): bool
    {
        $this->hash = '';

        return true;
    }

    /**
     * @return bool
     */
    public function confirmed(): bool
    {
        return ($this->getHash() === '');
    }
}
