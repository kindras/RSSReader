<?php

class Connection extends PDO
{

    /**
     * @param string $query
     * @param array  $parameters
     *
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function executeQuery($query, $wantResult = false, array $parameters = [])
    {
        $stmt = $this->prepare($query);
        
        foreach ($parameters as $name => $value)
        {
            $stmt->bindValue(':' . $name, $value);
        }

        $result = $stmt->execute();
        if($wantResult)
        {
            $result = $stmt;
        }
        return $result;
    }

}
