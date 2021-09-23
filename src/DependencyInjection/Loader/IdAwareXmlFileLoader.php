<?php

declare (strict_types=1);
namespace ConfigTransformer202109234\Symplify\ConfigTransformer\DependencyInjection\Loader;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use InvalidArgumentException;
use ConfigTransformer202109234\Nette\Utils\Strings;
use ConfigTransformer202109234\Symfony\Component\Config\FileLocatorInterface;
use ConfigTransformer202109234\Symfony\Component\Config\Util\Exception\XmlParsingException;
use ConfigTransformer202109234\Symfony\Component\Config\Util\XmlUtils;
use ConfigTransformer202109234\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109234\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202109234\Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use ConfigTransformer202109234\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202109234\Symplify\ConfigTransformer\Naming\UniqueNaming;
use ConfigTransformer202109234\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension\AliasAndNamespaceConfigurableExtension;
use ConfigTransformer202109234\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * Mimics https://github.com/symfony/symfony/commit/b8c68da0107a4f433dd414a355ea5589da0da0e8 for Symfony 3.3-
 */
final class IdAwareXmlFileLoader extends \ConfigTransformer202109234\Symfony\Component\DependencyInjection\Loader\XmlFileLoader
{
    /**
     * @var string
     */
    private const ID = 'id';
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var int|null
     */
    private $count;
    /**
     * @var \Symplify\ConfigTransformer\Naming\UniqueNaming
     */
    private $uniqueNaming;
    /**
     * @var \Symplify\ConfigTransformer\Collector\XmlImportCollector
     */
    private $xmlImportCollector;
    public function __construct(\ConfigTransformer202109234\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \ConfigTransformer202109234\Symfony\Component\Config\FileLocatorInterface $fileLocator, \ConfigTransformer202109234\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer202109234\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
        parent::__construct($containerBuilder, $fileLocator);
        $this->privatesCaller = new \ConfigTransformer202109234\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function import($resource, $type = null, $ignoreErrors = \false, $sourceResource = null, $exclude = null) : void
    {
        $this->xmlImportCollector->addImport($resource, $ignoreErrors);
    }
    /**
     * @param string|null $type
     */
    public function load($resource, $type = null) : void
    {
        $path = $this->locator->locate($resource);
        if (!\is_string($path)) {
            throw new \ConfigTransformer202109234\Symfony\Component\Config\Util\Exception\XmlParsingException();
        }
        // mostly mimics parseFileToDOM(), just without validation, that often breaks due to missing extension
        $domDocument = $this->parseFileToDOMWithoutValidation($path);
        $this->container->fileExists($path);
        $defaults = $this->privatesCaller->callPrivateMethod($this, 'getServiceDefaults', [$domDocument, $path]);
        $this->processAnonymousServices($domDocument, $path);
        // imports
        $this->privatesCaller->callPrivateMethod($this, 'parseImports', [$domDocument, $path]);
        // parameters
        $this->privatesCaller->callPrivateMethod($this, 'parseParameters', [$domDocument, $path]);
        // faking extensions
        $aliasAndNamespaceConfigurableExtension = new \ConfigTransformer202109234\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension\AliasAndNamespaceConfigurableExtension('doctrine', 'http://symfony.com/schema/dic/doctrine');
        $this->container->registerExtension($aliasAndNamespaceConfigurableExtension);
        $this->privatesCaller->callPrivateMethod($this, 'loadFromExtensions', [$domDocument]);
        // services
        try {
            $this->privatesCaller->callPrivateMethod($this, 'parseDefinitions', [$domDocument, $path, $defaults]);
        } finally {
            $this->instanceof = [];
            $this->registerAliasesForSinglyImplementedInterfaces();
        }
    }
    private function processAnonymousServices(\DOMDocument $xml, string $file) : void
    {
        $this->count = 0;
        $definitions = [];
        $suffix = '~' . \ConfigTransformer202109234\Symfony\Component\DependencyInjection\ContainerBuilder::hash($file);
        $domxPath = new \DOMXPath($xml);
        $domxPath->registerNamespace('container', self::NS);
        $definitions = $this->processAnonymousServicesInArguments($domxPath, $suffix, $file, $definitions);
        /** @var DOMNodeList<DOMNode> $nodeWithIds */
        $nodeWithIds = $domxPath->query('//container:services/container:service[@id]');
        $hasNamedServices = (bool) $nodeWithIds->length;
        // anonymous services "in the wild"
        $anonymousServiceNodes = $domxPath->query('//container:services/container:service[not(@id)]');
        if ($anonymousServiceNodes !== \false) {
            /** @var DOMElement $node */
            foreach ($anonymousServiceNodes as $node) {
                $id = $this->createAnonymousServiceId($hasNamedServices, $node, $file);
                $node->setAttribute(self::ID, $id);
                $definitions[$id] = [$node, $file, \true];
            }
        }
        // resolve definitions
        \uksort($definitions, 'strnatcmp');
        $inversedDefinitions = \array_reverse($definitions);
        foreach ($inversedDefinitions as $id => [$domElement, $file]) {
            $definition = $this->privatesCaller->callPrivateMethod($this, 'parseDefinition', [$domElement, $file, new \ConfigTransformer202109234\Symfony\Component\DependencyInjection\Definition()]);
            if ($definition !== null) {
                $this->setDefinition($id, $definition);
            }
        }
    }
    /**
     * @return mixed[]
     */
    private function processAnonymousServicesInArguments(\DOMXPath $domxPath, string $suffix, string $file, array $definitions) : array
    {
        $nodes = $domxPath->query('//container:argument[@type="service"][not(@id)]|//container:property[@type="service"][not(@id)]|//container:bind[not(@id)]|//container:factory[not(@service)]|//container:configurator[not(@service)]');
        if ($nodes !== \false) {
            /** @var DOMElement $node */
            foreach ($nodes as $node) {
                // get current service id
                $parentNode = $node->parentNode;
                \assert($parentNode instanceof \DOMElement);
                // @see https://stackoverflow.com/a/28944/1348344
                $parentServiceId = $parentNode->getAttribute('id');
                $services = $this->privatesCaller->callPrivateMethod($this, 'getChildren', [$node, 'service']);
                if ($services !== []) {
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
    private function createUniqueServiceNameFromClass(\DOMElement $serviceDomElement, string $parentServiceId) : string
    {
        $class = $serviceDomElement->getAttribute('class');
        $serviceName = $parentServiceId . '.' . $this->createServiceNameFromClass($class);
        return $this->uniqueNaming->uniquateName($serviceName);
    }
    private function createServiceNameFromClass(string $class) : string
    {
        $serviceName = \ConfigTransformer202109234\Nette\Utils\Strings::replace($class, '#\\\\#', '.');
        $serviceName = \strtolower($serviceName);
        return $this->uniqueNaming->uniquateName($serviceName);
    }
    private function createAnonymousServiceId(bool $hasNamedServices, \DOMElement $domElement, string $file) : string
    {
        $className = $domElement->getAttribute('class');
        if ($hasNamedServices) {
            return $this->createServiceNameFromClass($className);
        }
        $hashedFileName = \hash('sha256', $file);
        return \sprintf('%d_%s', ++$this->count, $hashedFileName);
    }
    private function parseFileToDOMWithoutValidation(string $path) : \DOMDocument
    {
        try {
            return \ConfigTransformer202109234\Symfony\Component\Config\Util\XmlUtils::loadFile($path);
        } catch (\InvalidArgumentException $invalidArgumentException) {
            $errorMessage = \sprintf('Unable to parse file "%s": %s', $path, $invalidArgumentException->getMessage());
            throw new \ConfigTransformer202109234\Symfony\Component\Config\Util\Exception\XmlParsingException($errorMessage, $invalidArgumentException->getCode(), $invalidArgumentException);
        }
    }
}
