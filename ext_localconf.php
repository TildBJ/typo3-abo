<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'TildBJ.' . $extensionKey,
        'Form',
        [
            'Default' => 'index,submit,reSubmit,confirm,unsubscribe',
        ],
        [
            'Default' => 'submit,reSubmit,confirm,unsubscribe',
        ]
    );

    $extbaseObjectContainer =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class);
    $extbaseObjectContainer->registerImplementation(\TildBJ\Abo\Domain\Abo::class, \TildBJ\Abo\Domain\Model\Abo::class);

    \TildBJ\Abo\Observer::add(\TildBJ\Abo\Observer\SaveToDatabase::class, 'submit');
    \TildBJ\Abo\Observer::add(\TildBJ\Abo\Observer\SendDoubleOptInMail::class, 'submit');
    \TildBJ\Abo\Observer::add(\TildBJ\Abo\Observer\Confirm::class, 'confirm');
    \TildBJ\Abo\Observer::add(\TildBJ\Abo\Observer\Unsubscribe::class, 'unsubscribe');
};
$boot($_EXTKEY);
unset($boot);
