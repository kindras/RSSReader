<?php

class QueryGenerator
{

    private static $directions = ['ASC', 'DESC'];

    public static function generateSelectQuery($tableName, $selects = null, $wheres = null, $orderBys = null, $direction = null)
    {
        // Design the selected attributes in the Query.
        $selectStmt = '*';
        if (!is_null($selects))
        {
            $selectStmt = '';
            foreach ($selects as $select)
            {
                if ($selectStmt !== '')
                {
                    $selectStmt = $selectStmt . ',' . $select;
                }
                else
                {
                    $selectStmt = $selectStmt . $select;
                }
            }
        }

        // Design the where statement in the Query.
        $whereStmt = null;
        if (!is_null($wheres))
        {
            $whereStmt = 'WHERE ';
            foreach ($wheres as $where)
            {
                if ($whereStmt !== 'WHERE ')
                {
                    $whereStmt = $whereStmt . ' AND ' . $where . ' = :' . $where;
                }
                else
                {
                    $whereStmt = $whereStmt . $where . ' = :' . $where;
                }
            }
        }

        // Design the orderBy statement in the query.
        $orderByStmt = null;
        if (!is_null($orderBys))
        {
            $orderByStmt = 'ORDER BY ';
            foreach ($orderBys as $orderBy)
            {
                if ($orderByStmt !== 'ORDER BY ')
                {
                    $orderByStmt = $orderByStmt . ',' . $orderBy;
                }
                else
                {
                    $orderByStmt = $orderByStmt . $orderBy;
                }
            }

            if (!in_array($direction, self::$directions))
            {
                $direction = self::$directions[0];
            }
        }
        else
        {
            $direction = null;
        }

        $query = 'SELECT ' . $selectStmt . ' FROM ' . $tableName . ' ' . $whereStmt . ' ' . $orderByStmt . ' ' . $direction;
        return $query;
    }

    public static function generateInsertQuery($tableName, array $attributes)
    {
        $query = 'INSERT INTO ' . $tableName . ' (';
        foreach ($attributes as $attribute)
        {
            $query = $query . $attribute . ',';
        }
        $query[strlen($query) - 1] = ')';

        $query = $query . ' VALUES (';
        foreach ($attributes as $attribute)
        {
            $query = $query . ':' . $attribute . ',';
        }
        $query[strlen($query) - 1] = ')';

        return $query;
    }

    public static function generateUpdateQuery($tableName, array $attributes, array $wheres = [])
    {
        $query = 'UPDATE ' . $tableName . ' SET';
        foreach ($attributes as $attribute)
        {
            $query = $query . ' ' . $attribute . ' = :' . $attribute . ',';
        }
        $query[strlen($query) - 1] = ' ';

        if (count($wheres) > 0)
        {
            $query = $query . ' WHERE';
            foreach ($wheres as $where)
            {
                $query = $query . ' ' . $where . ' = :' . $where . ',';
            }
            $query[strlen($query) - 1] = ' ';
        }

        return $query;
    }

    public static function generateDeleteQuery($tableName, array $wheres = [])
    {
        $query = 'DELETE FROM ' . $tableName . '';

        if (count($wheres) > 0)
        {
            $query = $query . ' WHERE';
            foreach ($wheres as $where)
            {
                $query = $query . ' ' . $where . ' = :' . $where . ',';
            }
            $query[strlen($query) - 1] = '';
        }

        return $query;
    }

}
