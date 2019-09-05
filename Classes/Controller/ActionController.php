<?php
declare(strict_types=1);

namespace TildBJ\Abo\Controller;

/**
 * Class ActionController
 */
class ActionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * {@inheritDoc}
     */
    protected function initializeActionMethodArguments()
    {
        $methodParameters = $this->reflectionService->getMethodParameters(get_class($this), $this->actionMethodName);
        foreach ($methodParameters as $parameterName => $parameterInfo) {
            $dataType = null;
            if (isset($parameterInfo['type'])) {
                $dataType = $parameterInfo['type'];
            } elseif ($parameterInfo['array']) {
                $dataType = 'array';
            }
            if ($dataType === null) {
                throw new \TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentTypeException('The argument type for parameter $' . $parameterName . ' of method ' . get_class($this) . '->' . $this->actionMethodName . '() could not be detected.', 1253175643);
            }

            $extbaseObjectContainer =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class);
            $dataType = $extbaseObjectContainer->getImplementationClassName($dataType);

            $defaultValue = isset($parameterInfo['defaultValue']) ? $parameterInfo['defaultValue'] : null;
            $this->arguments->addNewArgument($parameterName, $dataType, $parameterInfo['optional'] === false, $defaultValue);
        }
    }
    /**
     * {@inheritDoc}
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
