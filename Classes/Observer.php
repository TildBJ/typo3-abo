<?php
declare(strict_types=1);

namespace TildBJ\Abo;

use TildBJ\Abo\Controller\DefaultController;
use TildBJ\Abo\Observer\ObserverInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Class Observer
 */
class Observer
{
    private const SLOT_METHOD_NAME = 'dispatch';

    /**
     * @var null
     */
    private static $signalSlotDispatcher = null;

    /**
     * @param string $observerClassName
     * @param string $signalName
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public static function add(string $observerClassName, string $signalName)
    {
        $observer = self::getInstanceFromClassName($observerClassName);

        self::getSignalSlotDispatcher()->connect(
          DefaultController::class,
          $signalName,
          $observer,
          self::SLOT_METHOD_NAME
        );
    }

    /**
     * @return Dispatcher
     */
    protected static function getSignalSlotDispatcher(): Dispatcher
    {
        self::$signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);

        return self::$signalSlotDispatcher;
    }

    /**
     * @param string $observerClassName
     * @return ObserverInterface
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    protected static function getInstanceFromClassName(string $observerClassName): ObserverInterface
    {
        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $instance = $objectManager->get($observerClassName);

        if (!$instance instanceof ObserverInterface) {
            throw new \TYPO3\CMS\Extbase\Object\Exception($observerClassName . ' must implement interface ' . ObserverInterface::class);
        }

        return $instance;
    }
}
