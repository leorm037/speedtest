<?php

use PaginaEmConstrucao\Core\Connection;

namespace PaginaEmConstrucao\Core;

class Model
{

    /** @var object|null */
    protected $data;

    /** @var PDOException|null */
    protected $fail;

    /** @var string|null */
    protected $message;

    /** @var string */
    protected $query;

    /** @var string */
    protected $params;

    /** @var string */
    private $order;

    /** @var int */
    protected $limit;

    /** @var int */
    protected $offset;

    /** @var string $entity database table */
    protected static $entity;

    /** @array $protected no update or create */
    protected static $protected;

    /** @var array $entity database table */
    protected static $required;

    public function __construct(string $entity, array $protected, array $required)
    {
        self::$entity = $entity;
        self::$protected = array_merge($protected, ['created_at', 'updated_at']);
        self::$required = $required;
    }

    /**
     * 
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }
        $this->data->$name = $value;
    }

    /**
     * 
     * @param $name
     * @return $value
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * 
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * 
     * @return object|null
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * 
     * @return \PDOException|null
     */
    public function fail(): ?\PDOException
    {
        return $this->fail;
    }

    /**
     * 
     * @param string $columns
     * @param string|null $terms
     * @param string|null $params
     * @return Model|mixed
     */
    public function find(string $columns = "*", ?string $terms = null, ?string $params = null)
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM " . static::$entity . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} . FROM " . static::$entity;
        return $this;
    }

    /**
     * 
     * @param string $columnOrder
     * @return Model
     */
    public function orderBy(string $columnOrder): Model
    {
        $this->order = " ORDER BY {$columnOrder} ";
        return $this;
    }

    /**
     * 
     * @param int $limit
     * @return Model
     */
    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit} ";
        return $this;
    }
    
    public function offset(int $offset): Model {
        $this->limit = " OFFSET {$offset} ";
        return $this;
    }

    /**
     * 
     * @param bool $all
     * @return null|array|mixed|Model
     */
    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connection::getInstance()->prepare($this->query . $this->order . $this->limit . $this->offset);
            $stmt->execute($this->params);
            
            if (!$stmt->rowCount()) {
                return null;
            }
            
            if($all) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }
            
            return $stmt->fetchObject(static::class);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            
            var_dump($exception);
            exit;
            return null;
        }
    }
    
    /**
     * 
     * @param string $key
     * @return int
     */
    public function count(string $key = "id"): int {
        $stmt = Connection::getInstance()->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

}
