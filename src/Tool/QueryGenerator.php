<?php

class QueryGenerator
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new QueryGenerator();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    private $directions = ['ASC', 'DESC'];
    private $selectDefault = '*';

    public function generateSelectQuery($tableName, array $selects = [], array $wheres = [], array $orderBys = [], $direction = 'ASC')
    {
        $selectStmt = $this->generateAttributeStatement($selects);
        $whereStmt = $this->generateAttributeWithValueStatement($wheres, 'WHERE');
        $orderByStmt = $this->generateAttributeStatement($orderBys, 'ORDER BY');

        if ($selectStmt === '') {
            $selectStmt = $this->selectDefault;
        }

        if ($orderByStmt !== '') {
            if (!in_array($direction, $this->directions)) {
                $direction = $this->directions[0];
            }
        } else {
            $direction = null;
        }

        $query = 'SELECT '.$selectStmt.' FROM '.$tableName.' '.$whereStmt.' '.$orderByStmt.' '.$direction;

        return $query;
    }

    public function generateInsertQuery($tableName, array $inserts)
    {
        $insertStmt = $this->generateAttributeStatement($inserts);
        $valueStmt = $this->generateValueStatement($inserts);

        $query = 'INSERT INTO '.$tableName.' ('.$insertStmt.') VALUES ('.$valueStmt.')';

        return $query;
    }

    public function generateUpdateQuery($tableName, array $sets, array $wheres = [])
    {
        $setStmt = $this->generateAttributeWithValueStatement($sets, 'SET');
        $whereStmt = $this->generateAttributeWithValueStatement($wheres, 'WHERE');

        $query = 'UPDATE '.$tableName.' '.$setStmt.' '.$whereStmt;

        return $query;
    }

    public function generateDeleteQuery($tableName, array $wheres = null)
    {
        $whereStmt = $this->generateAttributeWithValueStatement($wheres, 'WHERE');

        $query = 'DELETE FROM '.$tableName.' '.$whereStmt;

        return $query;
    }

    // Private method for Query Generation.
    private function generateAttributeWithValueStatement($attributes, $keyword = null)
    {
        $stmt = '';
        foreach ($attributes as $attribute) {
            if ($stmt !== '') {
                $stmt .= ',';
            }
            $stmt .= $attribute.' = :'.$attribute;
        }
        $stmt = (!is_null($keyword) && $stmt !== '') ? $this->addKeywordToStatement($stmt, $keyword) : $stmt;

        return $stmt;
    }

    private function generateValueStatement($attributes, $keyword = null)
    {
        $stmt = '';
        foreach ($attributes as $attribute) {
            if ($stmt !== '') {
                $stmt .= ',';
            }
            $stmt .= ':'.$attribute;
        }
        $stmt = (!is_null($keyword) && $stmt !== '') ? $this->addKeywordToStatement($stmt, $keyword) : $stmt;

        return $stmt;
    }

    private function generateAttributeStatement($attributes, $keyword = null)
    {
        $stmt = '';
        foreach ($attributes as $attribute) {
            if ($stmt !== '') {
                $stmt .= ',';
            }
            $stmt .= $attribute;
        }
        $stmt = (!is_null($keyword) && $stmt !== '') ? $this->addKeywordToStatement($stmt, $keyword) : $stmt;

        return $stmt;
    }

    private function addKeywordToStatement($stmt, $keyword)
    {
        return $keyword.' '.$stmt;
    }
}
