<?php

namespace Alexdeovidal\Crud;


use JsonException;

/**
 * methods  crud
 */
class Resource
{
    /**
     * @var
     */
    private mixed $limit;
    /**
     * @var
     */
    private mixed $offset;
    /**
     * @var
     */
    private mixed $group;
    /**
     * @var
     */
    private mixed $order;
    /**
     * @var
     */
    private mixed $count;
    /**
     * @var
     */
    private mixed $filter;
    /**
     * @return mixed
     */
    protected function getLimit(): mixed
    {
        return (!empty( $this->limit) && $this->limit <= 10 ?  $this->limit : 10);
    }
    /**
     * @param mixed $limit
     */
    protected function setLimit($limit): void
    {
        $this->limit = (int) ($limit > 0 ? $limit  : null);
    }
    /**
     * @return mixed
     */
    protected function getOffset(): mixed
    {
        return $this->offset;
    }

    /**
     * @param mixed $page
     * @throws JsonException
     */
    protected function setOffset(mixed $page): void
    {
        $page = (int) $page;
        $offset = null;
        //prevent page=0
        if($page > 0){
            $offset = ($this->getLimit() * $page) - $this->getLimit();
            if($offset > $this->count) {
                self::response(400, 'not results');
            }
        }
        $this->offset = $offset;
    }
    /**
     * @return mixed
     */
    protected function getGroup(): mixed
    {
        return $this->group;
    }
    /**
     * @param mixed $group
     */
    protected function setGroup($group): void
    {
        $this->group = $group;
    }
    /**
     * @return mixed
     */
    protected function getOrder(): mixed
    {
        return $this->order;
    }
    /**
     * @param mixed $order
     */
    protected function setOrder(mixed $order): void
    {
        $this->order = (
            str_starts_with($order, '-')
                ? substr($order, 1) . ' DESC'
                : $order . ' ASC');
    }
    /**
     * @return mixed
     */
    protected function getFilter(): mixed
    {
        return $this->filter;
    }
    /**
     * set filters
     */
    protected function setFilter(): void
    {
        if($this->order) {
            $this->filter .= ' ORDER BY ' . $this->getOrder();
        }
        if($this->group) {
            $this->filter .= ' GROUP BY ' . $this->getGroup();
        }
        if($this->limit) {
            $this->filter .= ' LIMIT ' . $this->getLimit();
        }
        if($this->offset) {
            $this->filter .= ' OFFSET ' . $this->getOffset();
        }
    }
    /**
     * @return mixed
     */
    protected function getCount(): mixed
    {
        return $this->count;
    }
    /**
     * @param mixed $count
     */
    protected function setCount(mixed $count): void
    {
        $this->count = $count;
    }

    /**
     * @param $code
     * @param $data
     * @return string
     * @throws JsonException
     */
    public static function response($code, $data): string
    {
        header('Content-Type: application/json;charset=utf-8');
        http_response_code($code);
        return json_encode([
            'data' => $data,
            'status' => Error::show($code),
            'code' => $code
        ], JSON_THROW_ON_ERROR);
    }
}