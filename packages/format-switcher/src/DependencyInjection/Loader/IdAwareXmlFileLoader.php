<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\Loader;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use Nette\Utils\Strings;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symplify\PackageBuilder\Reflection\PrivatesCaller;

/**
 * Mimics https://github.com/symfony/symfony/commit/b8c68da0107a4f433dd414a355ea5589da0da0e8 for Symfony 3.3-
 */
final class IdAwareXmlFileLoader extends XmlFileLoader
{
    /**
     * @var string
     */
    private const ID = 'id';

    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;

    /**
     * @var int
     */
    private $count;

    /**
     * @var array<string, int>
     */
    private $anonymousServicesNames = [];

    public function __construct(ContainerBuilder $containerBuilder, FileLocatorInterface $fileLocator)
    {
        parent::__construct($containerBuilder, $fileLocator);

        $this->privatesCaller = new PrivatesCaller();
    }

    public function load($resource, ?string $type = null): void
    {
        $path = $this->locator->locate($resource);

        $xml = $this->privatesCaller->callPrivateMethod($this, 'parseFileToDOM', $path);
        $this->container->fileExists($path);

        $defaults = $this->privatesCaller->callPrivateMethod($this, 'getServiceDefaults', $xml, $path);
        $this->processAnonymousServices($xml, $path);

        // imports
        $this->privatesCaller->callPrivateMethod($this, 'parseImports', $xml, $path);

        // parameters
        $this->privatesCaller->callPrivateMethod($this, 'parseParameters', $xml, $path);

        // extensions
        $this->privatesCaller->callPrivateMethod($this, 'loadFromExtensions', $xml);

        // services
        try {
            $this->privatesCaller->callPrivateMethod($this, 'parseDefinitions', $xml, $path, $defaults);
        } finally {
            $this->instanceof = [];
            $this->registerAliasesForSinglyImplementedInterfaces();
        }
    }

    private function processAnonymousServices(DOMDocument $domDocument, string $file): void
    {
        $this->count = 0;
        $definitions = [];
        $suffix = '~' . ContainerBuilder::hash($file);

        $xpath = new DOMXPath($domDocument);
        $xpath->registerNamespace('container', self::NS);

        $definitions = $this->processAnonymousServicesInArguments($xpath, $suffix, $file, $definitions);

        /** @var DOMNodeList $nodeWithIds */
        $nodeWithIds = $xpath->query('//container:services/container:service[@id]');
        $hasNamedServices = (bool) $nodeWithIds->length;

        // anonymous services "in the wild"
        if (false !== $nodes = $xpath->query('//container:services/container:service[not(@id)]')) {
            /** @var DOMElement $node */
            foreach ($nodes as $node) {
                $id = $this->createAnonymousServiceId($hasNamedServices, $node, $file);
                $node->setAttribute(self::ID, $id);
                $definitions[$id] = [$node, $file, true];
            }
        }

        // resolve definitions
        uksort($definitions, 'strnatcmp');

        foreach (array_reverse($definitions) as $id => [$domElement, $file]) {
            if (null !== $definition = $this->privatesCaller->callPrivateMethod(
                $this,
                'parseDefinition',
                $domElement,
                $file,
                new Definition()
            )) {
                $this->setDefinition($id, $definition);
            }
        }
    }

    private function processAnonymousServicesInArguments(
        DOMXPath $domxPath,
        string $suffix,
        string $file,
        array $definitions
    ): array {
        if (false !== $nodes = $domxPath->query(
            '//container:argument[@type="service"][not(@id)]|//container:property[@type="service"][not(@id)]|//container:bind[not(@id)]|//container:factory[not(@service)]|//container:configurator[not(@service)]'
        )) {
            /** @var DOMElement $node */
            foreach ($nodes as $node) {
                // get current service id

                $parentNode = $node->parentNode;
                assert($parentNode instanceof DOMElement);

                // @see https://stackoverflow.com/a/28944/1348344
                $parentServiceId = $parentNode->getAttribute('id');

                if ($services = $this->privatesCaller->callPrivateMethod($this, 'getChildren', $node, 'service')) {
                    $id = $this->createUniqueServiceNameFromClass($services[0], $parentServiceId);

                    $node->setAttribute(self::ID, $id);
                    $node->setAttribute('service', $id);

                    $definitions[$id] = [$services[0], $file];
                    $services[0]->setAttribute(self::ID, $id);

                    // anonymous services are always private
                    // we could not use the constant false here, because of XML parsing
                    $services[0]->setAttribute('public', 'false');
                }
            }
        }

        return $definitions;
    }

    private function createUniqueServiceNameFromClass(DOMElement $serviceDomElement, string $parentServiceId): string
    {
        $class = $serviceDomElement->getAttribute('class');
        $serviceName = $parentServiceId . '.' . $this->createServiceNameFromClass($class);

        if (isset($this->anonymousServicesNames[$serviceName])) {
            $serviceNameCounter = $this->anonymousServicesNames[$serviceName];
            $this->anonymousServicesNames[$serviceName] = ++$serviceNameCounter;
            $serviceName .= '.' . $serviceNameCounter;
        } else {
            $this->anonymousServicesNames[$serviceName] = 1;
        }

        return $serviceName;
    }

    private function createServiceNameFromClass(string $class): string
    {
        $serviceName = Strings::replace($class, '#\\\\#', '.');
        return strtolower($serviceName);
    }

    private function createAnonymousServiceId(bool $hasNamedServices, DOMElement $domElement, string $file): string
    {
        if ($hasNamedServices) {
            $className = $domElement->getAttribute('class');
            $id = $this->createServiceNameFromClass($className);
        } else {
            // give it a unique name
            $id = sprintf('%d_%s', ++$this->count, hash('sha256', $file));
        }
        return $id;
    }
}
