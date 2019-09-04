<?php
declare(strict_types=1);

namespace TildBJ\Abo\Observer;

use TildBJ\Abo\Domain\Abo;

/**
 * Interface ObserverInterface
 * @package TildBJ\Abo\Observer
 */
interface ObserverInterface
{
    /**
     * @param Abo $abo
     * @return array
     */
    public function dispatch(Abo &$abo): array;
}
