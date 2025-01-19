<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\Cache\Adapter;

use ConfigTransformerPrefix202501\Doctrine\DBAL\ArrayParameterType;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Configuration;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Connection;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Driver\ServerInfoAwareConnection;
use ConfigTransformerPrefix202501\Doctrine\DBAL\DriverManager;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Exception as DBALException;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Exception\TableNotFoundException;
use ConfigTransformerPrefix202501\Doctrine\DBAL\ParameterType;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Schema\DefaultSchemaManagerFactory;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Schema\Schema;
use ConfigTransformerPrefix202501\Doctrine\DBAL\ServerVersionProvider;
use ConfigTransformerPrefix202501\Doctrine\DBAL\Tools\DsnParser;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\PruneableInterface;
class DoctrineDbalAdapter extends AbstractAdapter implements PruneableInterface
{
    private const MAX_KEY_LENGTH = 255;
    /**
     * @var \Symfony\Component\Cache\Marshaller\MarshallerInterface
     */
    private $marshaller;
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $conn;
    /**
     * @var string
     */
    private $platformName;
    /**
     * @var string
     */
    private $serverVersion;
    /**
     * @var string
     */
    private $table = 'cache_items';
    /**
     * @var string
     */
    private $idCol = 'item_id';
    /**
     * @var string
     */
    private $dataCol = 'item_data';
    /**
     * @var string
     */
    private $lifetimeCol = 'item_lifetime';
    /**
     * @var string
     */
    private $timeCol = 'item_time';
    /**
     * @var string
     */
    private $namespace;
    /**
     * You can either pass an existing database Doctrine DBAL Connection or
     * a DSN string that will be used to connect to the database.
     *
     * The cache table is created automatically when possible.
     * Otherwise, use the createTable() method.
     *
     * List of available options:
     *  * db_table: The name of the table [default: cache_items]
     *  * db_id_col: The column where to store the cache id [default: item_id]
     *  * db_data_col: The column where to store the cache data [default: item_data]
     *  * db_lifetime_col: The column where to store the lifetime [default: item_lifetime]
     *  * db_time_col: The column where to store the timestamp [default: item_time]
     *
     * @throws InvalidArgumentException When namespace contains invalid characters
     * @param \Doctrine\DBAL\Connection|string $connOrDsn
     */
    public function __construct($connOrDsn, string $namespace = '', int $defaultLifetime = 0, array $options = [], ?MarshallerInterface $marshaller = null)
    {
        if (isset($namespace[0]) && \preg_match('#[^-+.A-Za-z0-9]#', $namespace, $match)) {
            throw new InvalidArgumentException(\sprintf('Namespace contains "%s" but only characters in [-+.A-Za-z0-9] are allowed.', $match[0]));
        }
        if ($connOrDsn instanceof Connection) {
            $this->conn = $connOrDsn;
        } else {
            if (!\class_exists(DriverManager::class)) {
                throw new InvalidArgumentException('Failed to parse DSN. Try running "composer require doctrine/dbal".');
            }
            if (\class_exists(DsnParser::class)) {
                $params = (new DsnParser(['db2' => 'ibm_db2', 'mssql' => 'pdo_sqlsrv', 'mysql' => 'pdo_mysql', 'mysql2' => 'pdo_mysql', 'postgres' => 'pdo_pgsql', 'postgresql' => 'pdo_pgsql', 'pgsql' => 'pdo_pgsql', 'sqlite' => 'pdo_sqlite', 'sqlite3' => 'pdo_sqlite']))->parse($connOrDsn);
            } else {
                $params = ['url' => $connOrDsn];
            }
            $config = new Configuration();
            if (\class_exists(DefaultSchemaManagerFactory::class)) {
                $config->setSchemaManagerFactory(new DefaultSchemaManagerFactory());
            }
            $this->conn = DriverManager::getConnection($params, $config);
        }
        $this->maxIdLength = self::MAX_KEY_LENGTH;
        $this->table = $options['db_table'] ?? $this->table;
        $this->idCol = $options['db_id_col'] ?? $this->idCol;
        $this->dataCol = $options['db_data_col'] ?? $this->dataCol;
        $this->lifetimeCol = $options['db_lifetime_col'] ?? $this->lifetimeCol;
        $this->timeCol = $options['db_time_col'] ?? $this->timeCol;
        $this->namespace = $namespace;
        $this->marshaller = $marshaller ?? new DefaultMarshaller();
        parent::__construct($namespace, $defaultLifetime);
    }
    /**
     * Creates the table to store cache items which can be called once for setup.
     *
     * Cache ID are saved in a column of maximum length 255. Cache data is
     * saved in a BLOB.
     *
     * @throws DBALException When the table already exists
     */
    public function createTable() : void
    {
        $schema = new Schema();
        $this->addTableToSchema($schema);
        foreach ($schema->toSql($this->conn->getDatabasePlatform()) as $sql) {
            $this->conn->executeStatement($sql);
        }
    }
    /**
     * @param \Closure $isSameDatabase
     */
    public function configureSchema(Schema $schema, Connection $forConnection) : void
    {
        if ($schema->hasTable($this->table)) {
            return;
        }
        $isSameDatabase = 2 < \func_num_args() ? \func_get_arg(2) : static function () {
            return \false;
        };
        if ($forConnection !== $this->conn && !$isSameDatabase(\Closure::fromCallable([$this->conn, 'executeStatement']))) {
            return;
        }
        $this->addTableToSchema($schema);
    }
    public function prune() : bool
    {
        $deleteSql = "DELETE FROM {$this->table} WHERE {$this->lifetimeCol} + {$this->timeCol} <= ?";
        $params = [\time()];
        $paramTypes = [ParameterType::INTEGER];
        if ('' !== $this->namespace) {
            $deleteSql .= " AND {$this->idCol} LIKE ?";
            $params[] = \sprintf('%s%%', $this->namespace);
            $paramTypes[] = ParameterType::STRING;
        }
        try {
            $this->conn->executeStatement($deleteSql, $params, $paramTypes);
        } catch (TableNotFoundException $exception) {
        }
        return \true;
    }
    protected function doFetch(array $ids) : iterable
    {
        $now = \time();
        $expired = [];
        $sql = "SELECT {$this->idCol}, CASE WHEN {$this->lifetimeCol} IS NULL OR {$this->lifetimeCol} + {$this->timeCol} > ? THEN {$this->dataCol} ELSE NULL END FROM {$this->table} WHERE {$this->idCol} IN (?)";
        $result = $this->conn->executeQuery($sql, [$now, $ids], [ParameterType::INTEGER, \class_exists(ArrayParameterType::class) ? ArrayParameterType::STRING : Connection::PARAM_STR_ARRAY])->iterateNumeric();
        foreach ($result as $row) {
            if (null === $row[1]) {
                $expired[] = $row[0];
            } else {
                (yield $row[0] => $this->marshaller->unmarshall(\is_resource($row[1]) ? \stream_get_contents($row[1]) : $row[1]));
            }
        }
        if ($expired) {
            $sql = "DELETE FROM {$this->table} WHERE {$this->lifetimeCol} + {$this->timeCol} <= ? AND {$this->idCol} IN (?)";
            $this->conn->executeStatement($sql, [$now, $expired], [ParameterType::INTEGER, \class_exists(ArrayParameterType::class) ? ArrayParameterType::STRING : Connection::PARAM_STR_ARRAY]);
        }
    }
    protected function doHave(string $id) : bool
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE {$this->idCol} = ? AND ({$this->lifetimeCol} IS NULL OR {$this->lifetimeCol} + {$this->timeCol} > ?)";
        $result = $this->conn->executeQuery($sql, [$id, \time()], [ParameterType::STRING, ParameterType::INTEGER]);
        return (bool) $result->fetchOne();
    }
    protected function doClear(string $namespace) : bool
    {
        if ('' === $namespace) {
            $sql = $this->conn->getDatabasePlatform()->getTruncateTableSQL($this->table);
        } else {
            $sql = "DELETE FROM {$this->table} WHERE {$this->idCol} LIKE '{$namespace}%'";
        }
        try {
            $this->conn->executeStatement($sql);
        } catch (TableNotFoundException $exception) {
        }
        return \true;
    }
    protected function doDelete(array $ids) : bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->idCol} IN (?)";
        try {
            $this->conn->executeStatement($sql, [\array_values($ids)], [\class_exists(ArrayParameterType::class) ? ArrayParameterType::STRING : Connection::PARAM_STR_ARRAY]);
        } catch (TableNotFoundException $exception) {
        }
        return \true;
    }
    /**
     * @return mixed[]|bool
     */
    protected function doSave(array $values, int $lifetime)
    {
        if (!($values = $this->marshaller->marshall($values, $failed))) {
            return $failed;
        }
        $platformName = $this->getPlatformName();
        $insertSql = "INSERT INTO {$this->table} ({$this->idCol}, {$this->dataCol}, {$this->lifetimeCol}, {$this->timeCol}) VALUES (?, ?, ?, ?)";
        switch (\true) {
            case 'mysql' === $platformName:
                $sql = $insertSql . " ON DUPLICATE KEY UPDATE {$this->dataCol} = VALUES({$this->dataCol}), {$this->lifetimeCol} = VALUES({$this->lifetimeCol}), {$this->timeCol} = VALUES({$this->timeCol})";
                break;
            case 'oci' === $platformName:
                // DUAL is Oracle specific dummy table
                $sql = "MERGE INTO {$this->table} USING DUAL ON ({$this->idCol} = ?) " . "WHEN NOT MATCHED THEN INSERT ({$this->idCol}, {$this->dataCol}, {$this->lifetimeCol}, {$this->timeCol}) VALUES (?, ?, ?, ?) " . "WHEN MATCHED THEN UPDATE SET {$this->dataCol} = ?, {$this->lifetimeCol} = ?, {$this->timeCol} = ?";
                break;
            case 'sqlsrv' === $platformName && \version_compare($this->getServerVersion(), '10', '>='):
                // MERGE is only available since SQL Server 2008 and must be terminated by semicolon
                // It also requires HOLDLOCK according to http://weblogs.sqlteam.com/dang/archive/2009/01/31/UPSERT-Race-Condition-With-MERGE.aspx
                $sql = "MERGE INTO {$this->table} WITH (HOLDLOCK) USING (SELECT 1 AS dummy) AS src ON ({$this->idCol} = ?) " . "WHEN NOT MATCHED THEN INSERT ({$this->idCol}, {$this->dataCol}, {$this->lifetimeCol}, {$this->timeCol}) VALUES (?, ?, ?, ?) " . "WHEN MATCHED THEN UPDATE SET {$this->dataCol} = ?, {$this->lifetimeCol} = ?, {$this->timeCol} = ?;";
                break;
            case 'sqlite' === $platformName:
                $sql = 'INSERT OR REPLACE' . \substr($insertSql, 6);
                break;
            case 'pgsql' === $platformName && \version_compare($this->getServerVersion(), '9.5', '>='):
                $sql = $insertSql . " ON CONFLICT ({$this->idCol}) DO UPDATE SET ({$this->dataCol}, {$this->lifetimeCol}, {$this->timeCol}) = (EXCLUDED.{$this->dataCol}, EXCLUDED.{$this->lifetimeCol}, EXCLUDED.{$this->timeCol})";
                break;
            default:
                $platformName = null;
                $sql = "UPDATE {$this->table} SET {$this->dataCol} = ?, {$this->lifetimeCol} = ?, {$this->timeCol} = ? WHERE {$this->idCol} = ?";
                break;
        }
        $now = \time();
        $lifetime = $lifetime ?: null;
        try {
            $stmt = $this->conn->prepare($sql);
        } catch (TableNotFoundException $exception) {
            if (!$this->conn->isTransactionActive() || \in_array($platformName, ['pgsql', 'sqlite', 'sqlsrv'], \true)) {
                $this->createTable();
            }
            $stmt = $this->conn->prepare($sql);
        }
        if ('sqlsrv' === $platformName || 'oci' === $platformName) {
            $bind = static function ($id, $data) use($stmt) {
                $stmt->bindValue(1, $id);
                $stmt->bindValue(2, $id);
                $stmt->bindValue(3, $data, ParameterType::LARGE_OBJECT);
                $stmt->bindValue(6, $data, ParameterType::LARGE_OBJECT);
            };
            $stmt->bindValue(4, $lifetime, ParameterType::INTEGER);
            $stmt->bindValue(5, $now, ParameterType::INTEGER);
            $stmt->bindValue(7, $lifetime, ParameterType::INTEGER);
            $stmt->bindValue(8, $now, ParameterType::INTEGER);
        } elseif (null !== $platformName) {
            $bind = static function ($id, $data) use($stmt) {
                $stmt->bindValue(1, $id);
                $stmt->bindValue(2, $data, ParameterType::LARGE_OBJECT);
            };
            $stmt->bindValue(3, $lifetime, ParameterType::INTEGER);
            $stmt->bindValue(4, $now, ParameterType::INTEGER);
        } else {
            $stmt->bindValue(2, $lifetime, ParameterType::INTEGER);
            $stmt->bindValue(3, $now, ParameterType::INTEGER);
            $insertStmt = $this->conn->prepare($insertSql);
            $insertStmt->bindValue(3, $lifetime, ParameterType::INTEGER);
            $insertStmt->bindValue(4, $now, ParameterType::INTEGER);
            $bind = static function ($id, $data) use($stmt, $insertStmt) {
                $stmt->bindValue(1, $data, ParameterType::LARGE_OBJECT);
                $stmt->bindValue(4, $id);
                $insertStmt->bindValue(1, $id);
                $insertStmt->bindValue(2, $data, ParameterType::LARGE_OBJECT);
            };
        }
        foreach ($values as $id => $data) {
            $bind($id, $data);
            try {
                $rowCount = $stmt->executeStatement();
            } catch (TableNotFoundException $exception) {
                if (!$this->conn->isTransactionActive() || \in_array($platformName, ['pgsql', 'sqlite', 'sqlsrv'], \true)) {
                    $this->createTable();
                }
                $rowCount = $stmt->executeStatement();
            }
            if (null === $platformName && 0 === $rowCount) {
                try {
                    $insertStmt->executeStatement();
                } catch (DBALException $exception) {
                    // A concurrent write won, let it be
                }
            }
        }
        return $failed;
    }
    /**
     * @internal
     * @param mixed $key
     */
    protected function getId($key) : string
    {
        if ('pgsql' !== ($this->platformName = $this->platformName ?? $this->getPlatformName())) {
            return parent::getId($key);
        }
        if (\strpos($key, "\x00") !== \false || \strpos($key, '%') !== \false || !\preg_match('//u', $key)) {
            $key = \rawurlencode($key);
        }
        return parent::getId($key);
    }
    private function getPlatformName() : string
    {
        if (isset($this->platformName)) {
            return $this->platformName;
        }
        $platform = $this->conn->getDatabasePlatform();
        switch (\true) {
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\MySQLPlatform:
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\MySQL57Platform:
                return 'mysql';
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\SqlitePlatform:
                return 'sqlite';
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\PostgreSQLPlatform:
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\PostgreSQL94Platform:
                return 'pgsql';
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\OraclePlatform:
                return 'oci';
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\SQLServerPlatform:
            case $platform instanceof \ConfigTransformerPrefix202501\Doctrine\DBAL\Platforms\SQLServer2012Platform:
                return 'sqlsrv';
            default:
                return \get_class($platform);
        }
    }
    private function getServerVersion() : string
    {
        if (isset($this->serverVersion)) {
            return $this->serverVersion;
        }
        if ($this->conn instanceof ServerVersionProvider || $this->conn instanceof ServerInfoAwareConnection) {
            return $this->serverVersion = $this->conn->getServerVersion();
        }
        // The condition should be removed once support for DBAL <3.3 is dropped
        $conn = \method_exists($this->conn, 'getNativeConnection') ? $this->conn->getNativeConnection() : $this->conn->getWrappedConnection();
        return $this->serverVersion = $conn->getAttribute(\PDO::ATTR_SERVER_VERSION);
    }
    private function addTableToSchema(Schema $schema) : void
    {
        $types = ['mysql' => 'binary', 'sqlite' => 'text'];
        $table = $schema->createTable($this->table);
        $table->addColumn($this->idCol, $types[$this->getPlatformName()] ?? 'string', ['length' => 255]);
        $table->addColumn($this->dataCol, 'blob', ['length' => 16777215]);
        $table->addColumn($this->lifetimeCol, 'integer', ['unsigned' => \true, 'notnull' => \false]);
        $table->addColumn($this->timeCol, 'integer', ['unsigned' => \true]);
        $table->setPrimaryKey([$this->idCol]);
    }
}
