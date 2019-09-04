<?php
declare(strict_types=1);

namespace TildBJ\Abo\Domain;

/**
 * Interface Abo
 */
interface Abo
{
    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @return bool
     */
    public function confirmed(): bool;

    /**
     * @return bool
     */
    public function confirm(): bool;
}
