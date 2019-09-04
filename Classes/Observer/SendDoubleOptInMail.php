<?php
declare(strict_types=1);

namespace TildBJ\Abo\Observer;

use TildBJ\Abo\Domain\Abo;
use TildBJ\Abo\Domain\Repository\AboRepository;
use TildBJ\Abo\Service\MailService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MailUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class SendDoubleOptInMail
 * @package TildBJ\Abo\Observer
 */
class SendDoubleOptInMail implements ObserverInterface
{
    private const TEMPLATE = 'EXT:abo/Resources/Private/Templates/Default/Mail.html';

    /**
     * @var AboRepository
     */
    protected $aboRepository;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * SendDoubleOptInMail constructor.
     * @param AboRepository $aboRepository
     * @param MailService $mailService
     */
    public function __construct(AboRepository $aboRepository, MailService $mailService)
    {
        $this->aboRepository = $aboRepository;
        $this->mailService = $mailService;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(Abo &$abo): array
    {
        if ($abo->confirmed()) {
            throw new \TildBJ\Abo\Exception\AlreadyConfirmedException();
        }
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(self::TEMPLATE);
        $mail = $view->assign('abo', $abo)->render();

        $this->mailService->send(MailUtility::getSystemFrom(), [$abo->getEmail()], 'Confirm your Abo', $mail);

        return [$abo];
    }
}
