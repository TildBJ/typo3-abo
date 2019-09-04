<?php
declare(strict_types=1);

namespace TildBJ\Abo\Observer;

use TildBJ\Abo\Domain\Abo;
use TildBJ\Abo\Domain\Repository\AboRepository;

/**
 * Class Unsubscribe
 * @package TildBJ\Abo\Observer
 */
class Unsubscribe implements ObserverInterface
{
    /**
     * @var AboRepository
     */
    protected $aboRepository;

    /**
     * AboService constructor.
     * @param AboRepository $aboRepository
     */
    public function __construct(AboRepository $aboRepository)
    {
        $this->aboRepository = $aboRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(Abo &$abo): array
    {
        $this->aboRepository->remove($abo);

        return [$abo];
    }
}
