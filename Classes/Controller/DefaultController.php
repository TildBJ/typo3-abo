<?php
declare(strict_types=1);

namespace TildBJ\Abo\Controller;

use TildBJ\Abo\Domain\Abo;
use TildBJ\Abo\Domain\Repository\AboRepository;
use TildBJ\Abo\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Class DefaultController
 * @package TildBJ\Abo\Controller
 */
class DefaultController extends ActionController
{
    /**
     * @var AboRepository
     */
    protected $aboRepository;

    /**
     * @var Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * @param Dispatcher $signalSlotDispatcher
     * @param AboRepository $aboRepository
     */
    public function __construct(Dispatcher $signalSlotDispatcher, AboRepository $aboRepository)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
        $this->aboRepository = $aboRepository;
    }

    /**
     * @param Abo|null $abo
     * @param string $nextAction
     */
    public function indexAction(Abo $abo = null, string $nextAction = 'submit')
    {
        $this->view->assignMultiple([
            'abo' => $abo,
            'action' => $nextAction,
        ]);
    }

    /**
     * @param Abo $abo
     */
    public function submitAction(Abo $abo)
    {
        $this->dispatch('submit', $abo);
        $this->addFlashMessage(LocalizationUtility::translate('flashmessage.submit'));

        $this->redirect('index');
    }

    /**
     * @param string $key
     */
    public function confirmAction(string $key)
    {
        if ($abo = $this->aboRepository->findByHash($key)->getFirst()) {
            $this->dispatch('confirm', $abo);
            $this->addFlashMessage(LocalizationUtility::translate('flashmessage.confirm'));
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('flashmessage.keyNotFound'), '', AbstractMessage::ERROR);
        }

        $this->redirect('index');
    }

    /**
     * @param Abo $abo
     */
    public function unsubscribeAction(Abo $abo)
    {
        if ($abo = $this->aboRepository->findByEmail($abo->getEmail())->getFirst()) {
            $this->dispatch('unsubscribe', $abo);
            $this->addFlashMessage(LocalizationUtility::translate('flashmessage.unsubsribe'));
            $this->redirect('index');
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('flashmessage.emailNotFound'), '', AbstractMessage::ERROR);
            $this->redirect('index', ['nextAction' => 'unsubscribe']);
        }

    }

    /**
     * @param string $signalName
     * @param Abo $abo
     */
    private function dispatch(string $signalName, Abo $abo)
    {
        try {
            $this->signalSlotDispatcher->dispatch(self::class, $signalName, [$abo]);
        } catch (\TildBJ\Abo\Exception\AlreadyConfirmedException $exception) {
            $this->addFlashMessage(LocalizationUtility::translate('flashmessage.alreadyConfirmed'), '', AbstractMessage::WARNING);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function redirect(string $action, array $arguments = [])
    {
        parent::redirect($action, 'Default', 'abo', $arguments);
    }
}
