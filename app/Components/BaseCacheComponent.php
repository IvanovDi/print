<?php

namespace App\Components;

abstract class BaseCacheComponent
{
    protected $cacheName = '';

    public function get($key = null)
    {
        if (!$this->hasCache()) {
            $data = $this->putCache();
        } else {
            $data = $this->getCache();
            if ($key) {
                return $data[$key];
            }
        }
        return $data;
    }

    protected function getCacheLifeTime()
    {
        return time() + 60*60*24*30;
    }

    protected function getCacheObject()
    {
        return \Cache::store('file');
    }

    protected function hasCache($id = null)
    {
        return $this->getCacheObject()->has($this->getCacheName($id));
    }

    protected function putCache()
    {
        $data = $this->getDataForCache();
        $this->getCacheObject()->put($this->getCacheName(), $data, $this->getCacheLifeTime());

        return $data;
    }

    protected function getCache()
    {
        return $this->getCacheObject()->get($this->getCacheName());
    }

    protected function getCacheName()
    {
        return $this->cacheName;
    }

    public function destroyCache($id = null)
    {
        if ($this->hasCache($id)) {
            $this->getCacheObject()->forget($this->getCacheName($id));
        }
    }

    abstract protected function getDataForCache();
}