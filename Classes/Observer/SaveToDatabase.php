<?php
declare(strict_types=1);

namespace TildBJ\Abo\Observer;

use TildBJ\Abo\Domain\Abo;
use TildBJ\Abo\Domain\Repository\AboRepository;

/**
 * Class SaveToDatabase
 * @package TildBJ\Abo\Observer
 */
class SaveToDatabase implements ObserverInterface
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
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $abos */
        $abos = $this->aboRepository->findByEmail($abo->getEmail());
        if ($abos->count() === 0) {
            $this->aboRepository->add($abo);
        } else {
            $abo = $abos->getFirst();
        }

        return [$abo];
    }
}
