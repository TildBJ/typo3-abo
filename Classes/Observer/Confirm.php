<?php
declare(strict_types=1);

namespace TildBJ\Abo\Observer;

use TildBJ\Abo\Domain\Abo;
use TildBJ\Abo\Domain\Repository\AboRepository;

/**
 * Class Confirm
 * @package TildBJ\Abo\Observer
 */
class Confirm implements ObserverInterface
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
        $abo->confirm();
        $this->aboRepository->update($abo);

        return [$abo];
    }
}
