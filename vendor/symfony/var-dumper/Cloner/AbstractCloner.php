<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110017\Symfony\Component\VarDumper\Cloner;

use ConfigTransformer202110017\Symfony\Component\VarDumper\Caster\Caster;
use ConfigTransformer202110017\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements \ConfigTransformer202110017\Symfony\Component\VarDumper\Cloner\ClonerInterface
{
    public static $defaultCasters = ['__PHP_Incomplete_Class' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\Caster', 'castPhpIncompleteClass'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\CutStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\CutArrayStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castCutArray'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ConstStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\EnumStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castEnum'], 'Closure' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClosure'], 'Generator' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castZendExtension'], 'ConfigTransformer202110017\\Doctrine\\Common\\Persistence\\ObjectManager' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Doctrine\\Common\\Proxy\\Proxy' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castCommonProxy'], 'ConfigTransformer202110017\\Doctrine\\ORM\\Proxy\\Proxy' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castOrmProxy'], 'ConfigTransformer202110017\\Doctrine\\ORM\\PersistentCollection' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castPersistentCollection'], 'ConfigTransformer202110017\\Doctrine\\Persistence\\ObjectManager' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'DOMException' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castException'], 'DOMStringList' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNameList' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMImplementation' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNode' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNode'], 'DOMNameSpaceNode' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNameSpaceNode'], 'DOMDocument' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocument'], 'DOMNodeList' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNamedNodeMap' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMCharacterData' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castCharacterData'], 'DOMAttr' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castAttr'], 'DOMElement' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castElement'], 'DOMText' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castText'], 'DOMTypeinfo' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castTypeinfo'], 'DOMDomError' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDomError'], 'DOMLocator' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLocator'], 'DOMDocumentType' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocumentType'], 'DOMNotation' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNotation'], 'DOMEntity' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castEntity'], 'DOMProcessingInstruction' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castProcessingInstruction'], 'DOMXPath' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castXPath'], 'XMLReader' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castErrorException'], 'Exception' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castException'], 'Error' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castError'], 'ConfigTransformer202110017\\Symfony\\Bridge\\Monolog\\Logger' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Symfony\\Component\\DependencyInjection\\ContainerInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Symfony\\Component\\HttpClient\\CurlHttpClient' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ConfigTransformer202110017\\Symfony\\Component\\HttpClient\\NativeHttpClient' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ConfigTransformer202110017\\Symfony\\Component\\HttpClient\\Response\\CurlResponse' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ConfigTransformer202110017\\Symfony\\Component\\HttpClient\\Response\\NativeResponse' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ConfigTransformer202110017\\Symfony\\Component\\HttpFoundation\\Request' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castRequest'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Exception\\ThrowingCasterException' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castThrowingCasterException'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\TraceStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castTraceStub'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\FrameStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castFrameStub'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Cloner\\AbstractCloner' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Symfony\\Component\\ErrorHandler\\Exception\\SilencedErrorContext' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castSilencedErrorContext'], 'ConfigTransformer202110017\\Imagine\\Image\\ImageInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ImagineCaster', 'castImage'], 'ConfigTransformer202110017\\Ramsey\\Uuid\\UuidInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\UuidCaster', 'castRamseyUuid'], 'ConfigTransformer202110017\\ProxyManager\\Proxy\\ProxyInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\PHPUnit\\Framework\\MockObject\\MockObject' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\PHPUnit\\Framework\\MockObject\\Stub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Prophecy\\Prophecy\\ProphecySubjectInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ConfigTransformer202110017\\Mockery\\MockInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'PDO' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdo'], 'PDOStatement' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileInfo'], 'SplFileObject' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileObject'], 'SplHeap' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'SplObjectStorage' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'OuterIterator' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castOuterIterator'], 'WeakReference' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castWeakReference'], 'Redis' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedis'], 'RedisArray' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castDateTime'], 'DateInterval' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castInterval'], 'DateTimeZone' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castTimeZone'], 'DatePeriod' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castPeriod'], 'GMP' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\GmpCaster', 'castGmp'], 'MessageFormatter' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\MemcachedCaster', 'castMemcached'], 'ConfigTransformer202110017\\Ds\\Collection' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castCollection'], 'ConfigTransformer202110017\\Ds\\Map' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castMap'], 'ConfigTransformer202110017\\Ds\\Pair' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPair'], 'ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DsPairStub' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPairStub'], 'CurlHandle' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':curl' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':dba' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], ':dba persistent' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], 'GdImage' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':gd' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':mysql link' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castMysqlLink'], ':pgsql large object' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLargeObject'], ':pgsql link' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql link persistent' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql result' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castResult'], ':process' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castProcess'], ':stream' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], 'OpenSSLCertificate' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':OpenSSL X.509' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':persistent stream' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], ':stream-context' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], ':xml' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], 'RdKafka' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castRdKafka'], 'ConfigTransformer202110017\\RdKafka\\Conf' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castConf'], 'ConfigTransformer202110017\\RdKafka\\KafkaConsumer' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castKafkaConsumer'], 'ConfigTransformer202110017\\RdKafka\\Metadata\\Broker' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castBrokerMetadata'], 'ConfigTransformer202110017\\RdKafka\\Metadata\\Collection' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castCollectionMetadata'], 'ConfigTransformer202110017\\RdKafka\\Metadata\\Partition' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castPartitionMetadata'], 'ConfigTransformer202110017\\RdKafka\\Metadata\\Topic' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicMetadata'], 'ConfigTransformer202110017\\RdKafka\\Message' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castMessage'], 'ConfigTransformer202110017\\RdKafka\\Topic' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopic'], 'ConfigTransformer202110017\\RdKafka\\TopicPartition' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicPartition'], 'ConfigTransformer202110017\\RdKafka\\TopicConf' => ['ConfigTransformer202110017\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicConf']];
    protected $maxItems = 2500;
    protected $maxString = -1;
    protected $minDepth = 1;
    private $casters = [];
    private $prevErrorHandler;
    private $classInfo = [];
    private $filter = 0;
    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(array $casters = null)
    {
        if (null === $casters) {
            $casters = static::$defaultCasters;
        }
        $this->addCasters($casters);
    }
    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or objects types to a callback.
     * Types are in the key, with a callable caster for value.
     * Resource types are to be prefixed with a `:`,
     * see e.g. static::$defaultCasters.
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters($casters)
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }
    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     * @param int $maxItems
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;
    }
    /**
     * Sets the maximum cloned length for strings.
     * @param int $maxString
     */
    public function setMaxString($maxString)
    {
        $this->maxString = $maxString;
    }
    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     * @param int $minDepth
     */
    public function setMinDepth($minDepth)
    {
        $this->minDepth = $minDepth;
    }
    /**
     * Clones a PHP variable.
     *
     * @param mixed $var    Any PHP variable
     * @param int   $filter A bit field of Caster::EXCLUDE_* constants
     *
     * @return Data The cloned variable represented by a Data object
     */
    public function cloneVar($var, $filter = 0)
    {
        $this->prevErrorHandler = \set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }
            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }
            return \false;
        });
        $this->filter = $filter;
        if ($gc = \gc_enabled()) {
            \gc_disable();
        }
        try {
            return new \ConfigTransformer202110017\Symfony\Component\VarDumper\Cloner\Data($this->doClone($var));
        } finally {
            if ($gc) {
                \gc_enable();
            }
            \restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }
    /**
     * Effectively clones the PHP variable.
     *
     * @param mixed $var Any PHP variable
     *
     * @return array The cloned variable represented in an array
     */
    protected abstract function doClone($var);
    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The object casted as array
     * @param \Symfony\Component\VarDumper\Cloner\Stub $stub
     */
    protected function castObject($stub, $isNested)
    {
        $obj = $stub->value;
        $class = $stub->class;
        if (\PHP_VERSION_ID < 80000 ? "\0" === ($class[15] ?? null) : \strpos($class, "@anonymous\0") !== \false) {
            $stub->class = \get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            [$i, $parents, $hasDebugInfo, $fileInfo] = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = \method_exists($class, '__debugInfo');
            foreach (\class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (\class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';
            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(\ConfigTransformer202110017\Symfony\Component\VarDumper\Cloner\Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = \ConfigTransformer202110017\Symfony\Component\VarDumper\Caster\Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(\ConfigTransformer202110017\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \ConfigTransformer202110017\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \ConfigTransformer202110017\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The resource casted as array
     * @param \Symfony\Component\VarDumper\Cloner\Stub $stub
     */
    protected function castResource($stub, $isNested)
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;
        try {
            if (!empty($this->casters[':' . $type])) {
                foreach ($this->casters[':' . $type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(\ConfigTransformer202110017\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \ConfigTransformer202110017\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \ConfigTransformer202110017\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}
