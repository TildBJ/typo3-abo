<?php
declare(strict_types=1);

namespace TildBJ\Abo\Utility;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Class ConfigurationUtility
 */
class ConfigurationUtility implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * ConfigurationUtility constructor.
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function __construct(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param array $settings
     */
    public function initializeSettings()
    {
        $typoScript = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $typoScript['plugin.']['tx_abo.'];
        if (is_array($settings)) {
            $this->settings = $settings;
        }
    }

    /**
     * @return array
     */
    public function getLayoutRootPaths(): array
    {
        return $this->getRootPaths('layoutRootPaths');
    }

    /**
     * @return array
     */
    public function getTemplateRootPaths(): array
    {
        return $this->getRootPaths('templateRootPaths');
    }

    /**
     * @return array
     */
    public function getPartialRootPaths(): array
    {
        return $this->getRootPaths('partialRootPaths');
    }

    /**
     * @param string $type
     * @return array
     */
    private function getRootPaths(string $type): array
    {
        if (!is_array($this->settings['view.'][$type . '.'])) {
            return [];
        }

        return $this->settings['view.'][$type . '.'];
    }
}
