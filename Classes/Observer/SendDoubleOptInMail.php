<?php
declare(strict_types=1);

namespace TildBJ\Abo\Observer;

use TildBJ\Abo\Domain\Abo;
use TildBJ\Abo\Domain\Repository\AboRepository;
use TildBJ\Abo\Service\MailService;
use TildBJ\Abo\Utility\LocalizationUtility;
use TildBJ\Abo\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\MailUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class SendDoubleOptInMail
 * @package TildBJ\Abo\Observer
 */
class SendDoubleOptInMail implements ObserverInterface
{
    /**
     * @var AboRepository
     */
    protected $aboRepository;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * @var ConfigurationUtility
     */
    protected $configurationUtility;

    /**
     * SendDoubleOptInMail constructor.
     * @param AboRepository $aboRepository
     * @param MailService $mailService
     */
    public function __construct(AboRepository $aboRepository, MailService $mailService, StandaloneView $standaloneView, ConfigurationUtility $configurationUtility)
    {
        $this->aboRepository = $aboRepository;
        $this->mailService = $mailService;
        $this->view = $standaloneView;
        $this->configurationUtility = $configurationUtility;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(Abo &$abo): array
    {
        if ($abo->confirmed()) {
            throw new \TildBJ\Abo\Exception\AlreadyConfirmedException();
        }

        $this->initializeView();

        $mail = $this->view->assign('abo', $abo)->render();

        $this->view->initializeRenderingContext();

        $this->mailService->send(
            MailUtility::getSystemFrom(),
            [$abo->getEmail()],
            LocalizationUtility::translate('mail.confirmation.subject'),
            $mail
        );

        return [$abo];
    }

    private function initializeView()
    {
        $layoutRootPaths = array_merge(
            ['EXT:abo/Resources/Private/Layouts/'],
            $this->configurationUtility->getLayoutRootPaths()
        );
        $templateRootPaths = array_merge(
            ['EXT:abo/Resources/Private/Templates/'],
            $this->configurationUtility->getTemplateRootPaths()
        );
        $partialRootPaths = array_merge(
            ['EXT:abo/Resources/Private/Templates/'],
            $this->configurationUtility->getPartialRootPaths()
        );

        $this->view->getRenderingContext()->setControllerAction('Mail');
        $this->view->getRenderingContext()->setControllerName('Default');

        $this->view->setLayoutRootPaths($layoutRootPaths);
        $this->view->setTemplateRootPaths($templateRootPaths);
        $this->view->setPartialRootPaths($partialRootPaths);
    }
}
