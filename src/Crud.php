<?php

namespace Alexdeovidal\Crud;
use JsonException;
use PDO;

/**
 * CRUD PDO
 */
class Crud extends Resource
{
    /**
     * @var mixed|PDO
     */
    private mixed $conn;

    /**
     * @var string
     */
    private string $table;

    /**
     * @param $table
     */
    public function __construct($table)
    {
        $this->conn = Conn::conn();
        $this->table = $table;
    }

    /**
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    protected function create($data): mixed
    {
        $columns = implode(",", array_keys(get_object_vars($data)));
        $values = ':' . implode(",:", array_keys(get_object_vars($data)));

        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $create = $this->conn->prepare($query);
        foreach ($data as $column => &$value) {
            $create->bindParam(':' . $column, $value);
        }
        if(!$create->execute()){
            Resource::response(500, 'look for the webmaster');
        }
        $data->id = $this->conn->lastInsertId();
        return $data;
    }

    /**
     * @param $columns
     * @param null $where
     * @param null $params
     * @param null $queryString
     * @return array
     * @throws JsonException
     */
    public function read($columns, $where = null, $params = null, $queryString = null): array
    {
        $this->queryString($queryString);

        //set count results
        $this->count($where, $params);

        if(isset($queryString->page)) {
            $this->setOffset($queryString->page);
        }

        if ($where) {
            $where = " WHERE $where";
        }

        $this->setFilter();
        $query = "SELECT $columns FROM $this->table$where" . $this->getFilter();
        $read = $this->conn->prepare($query);

        if ($params) {
            parse_str($params, $resultParams);
            foreach ($resultParams as $column => $value) {
                $read->bindParam(':' . $column, $value);
            }
        }
        $read->execute();
        $pages = null;
        if($this->getCount() > 0 && $read->rowCount() > 0)
            $pages = ceil($this->getCount() / $read->rowCount());

        return [
            'limit' => $this->getLimit(),
            'page' => (int) (isset($queryString->page) && $queryString->page > 0 ? $queryString->page : 1),
            'pages' => $pages,
            'results' => $read->rowCount(),
            'all' => $this->getCount(),
            $this->table => $read->fetchAll()
        ];
    }

    /**
     * @param $data
     * @param $terms
     * @return mixed
     * @throws JsonException
     */
    protected function update($data, $terms): mixed
    {
        $dateSet = [];
        foreach ($data as $column => $value) {
            $dateSet[] = "$column = :$column";
        }
        $dateSet = implode(", ", $dateSet);

        $query = "UPDATE $this->table SET $dateSet WHERE $terms";
        $update = $this->conn->prepare($query);
        foreach ($data as $column => &$value) {
            $update->bindParam(':' . $column, $value);
        }
        if(!$update->execute()){
            Resource::response(500, 'look for the webmaster');
        }

        return $data;
    }

    /**
     * @param $id
     * @return bool
     * @throws JsonException
     */
    protected function delete($id): bool
    {
        $query = "DELETE FROM $this->table WHERE id=$id";
        $delete = $this->conn->prepare($query);
        if(!$delete->execute()){
            Resource::response(500, 'look for the webmaster');
        }
        return true;
    }

    /**
     * @param $queryString
     */
    protected function queryString($queryString): void
    {
        if(isset($queryString->limit)) {
            $this->setLimit($queryString->limit);
        }
        if(isset($queryString->group)) {
            $this->setGroup($queryString->group);
        }
        if(isset($queryString->order)) {
            $this->setOrder($queryString->order);
        }
    }

    /**
     * @param null $where
     * @param null $params
     * @return int
     */
    protected function count($where = null, $params = null): int
    {
        if ($where) {
            $where = " WHERE $where";
        }
        $query = "SELECT id FROM $this->table$where";
        $read = $this->conn->prepare($query);
        if ($params) {
            parse_str($params, $result);
            foreach ($result as $column => $value) {
                $read->bindParam(':' . $column, $value);
            }
        }
        $read->execute();
        $this->setCount($read->rowCount());
        return $read->rowCount();
    }

}