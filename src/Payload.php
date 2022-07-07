<?php

namespace Php\Data;

final class Payload
{
    /**  @var array */
    private $container;

    /**
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->container = [ 'data' => $data ?? [], ];
    }

    /**
     * Get added data by 'dot' separated keys. Ex. 'animal.cat.name'
     * @param string $dotSeparatedKey
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $dotSeparatedKey, $default = null)
    {
        return $this->_getValue($dotSeparatedKey, $default);
    }

    /**
     * Set data by dot separated key
     * @param string $dotSeparatedKey
     * @param mixed $value
     * @return $this
     */
    public function set(string $dotSeparatedKey, $value): self
    {
        return $this->_addValue($dotSeparatedKey, $value);
    }

    /**
     * @param string $dotSeparatedKey
     * @param mixed $value
     * @return $this
     */
    public function add(string $dotSeparatedKey, $value): self
    {
        return $this->_addValue($dotSeparatedKey, $value);
    }

    /**
     * Import the data which was exported earlier
     * @param array $data
     * @return $this
     */
    public function import(array $data): self
    {
        $this->container['data'] = $data;
        return $this;
    }

    /**
     * Export the build data, so it can be transferred and rebuild
     * @return array
     */
    public function export(): array
    {
        return $this->container['data'];
    }

    /**
     * @param string $dotSeparatedKey
     * @param $default|null
     * @return mixed|null
     */
    private function _getValue(string $dotSeparatedKey, $default = null)
    {
        $keys = explode('.', $dotSeparatedKey);
        $level = $this->container['data'];
        foreach ($keys as $key) {
            if (isset($level[$key])) {
                $level = $level[$key];
                continue;
            }
            return $default;
        }

        return $level;
    }

    /**
     * @param string $dotSeparatedKey
     * @param mixed $value
     * @return $this
     */
    private function _addValue(string $dotSeparatedKey, $value): self
    {
        $keys = explode('.', $dotSeparatedKey);
        $lastKey = array_pop($keys);

        $level = &$this->container['data'];
        foreach ($keys as $key) {
            if (!isset($level[$key])) {
                $level[$key] = [];
            }
            $level = &$level[$key];
        }

        $level[$lastKey] = $value;

        return $this;
    }
}
