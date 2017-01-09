<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal\Pagination;

/**
 * A generic cursor adapter.
 *
 * @author Isern Palaus <ipalaus@ipalaus.com>
 * @author Michele Massari <michele@michelemassari.net>
 */
class JsonCursor implements CursorInterface
{	
    /**
     * Current cursor value.
     *
     * @var mixed
     */
    protected $current;

    /**
     * Previous cursor value.
     *
     * @var mixed
     */
    protected $prev;

    /**
     * Next cursor value.
     *
     * @var mixed
     */
    protected $next;

    /**
     * Items being held for the current cursor position.
     *
     * @var int
     */
    protected $count;
	
    /**
     * Current URL.
     *
     * @var mixed
     */
	protected $url;
	
    /**
     * DB MinID.
     *
     * @var int
     */
	protected $minId;

    /**
     * DB MaxID.
     *
     * @var int
     */
	protected $maxId;


    /**
     * Create a new Cursor instance.
     *
     * @param int    $current
     * @param null   $prev
     * @param mixed  $next
     * @param int    $count
	 * @param string $url
	 * @param int    $minId
	 * @param int    $maxId
     *
     * @return void
     */
    public function __construct($current = null, $prev = null, $next = null, $count = null, $url = null, $minId = 0, $maxId = 0)
    {
        $this->current = $current;
        $this->prev = $prev;
        $this->next = $next;
        $this->count = $count;
		$this->url = $url;
		$this->minId = $minId;
		$this->maxId = $maxId;
    }

    /**
     * Get the current cursor value.
     *
     * @return mixed
     */
    public function getCurrent()
    {	
        return base64_encode($this->current);
    }

    /**
     * Set the current cursor value.
     *
     * @param int $current
     *
     * @return Cursor
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get the prev cursor value.
     *
     * @return mixed
     */
    public function getPrev()
    {
        return base64_encode($this->prev);
    }

    /**
     * Set the prev cursor value.
     *
     * @param int $prev
     *
     * @return Cursor
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;

        return $this;
    }

    /**
     * Get the next cursor value.
     *
     * @return mixed
     */
    public function getNext()
    {
        return base64_encode($this->next);
    }

    /**
     * Set the next cursor value.
     *
     * @param int $next
     *
     * @return Cursor
     */
    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Returns the total items in the current cursor.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
	
    /**
     *  Returns the current URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
	
    /**
     * Returns the total items in the current cursor.
     *
     * @return int
     */
    public function getMinId()
    {
        return base64_encode($this->minId);
    }
	
    /**
     * Returns the total items in the current cursor.
     *
     * @return int
     */
    public function getMaxId()
    {
        return base64_encode($this->maxId);
    }

    /**
     * Set the total items in the current cursor.
     *
     * @param int $count
     *
     * @return Cursor
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Returns the previous url
     *
     * @param string $url
     *
     * @return string
     */
	public function getPrevUrl($url) 
	{
		$scheme = parse_url($url, PHP_URL_SCHEME);
		$host = parse_url($url, PHP_URL_HOST);
		$path = parse_url($url, PHP_URL_PATH);
		$query = parse_url($url, PHP_URL_QUERY);
		
		parse_str($query, $queries);
		
		$limit = $this->getLimit($url);

		$queries['cursor'] = $this->getCurrent();
		$queries['limit'] = $limit;
		$queries['previous'] = $this->getCurrent();
		$queries['direction'] = 'prev';

		$query = http_build_query($queries);

		return $scheme.'://'.$host.$path.'?'.urldecode($query);
	}
	
    /**
     * Returns the next url
     *
     * @param string $url
     *
     * @return string
     */
	public function getNextUrl($url) 
	{
		$scheme = parse_url($url, PHP_URL_SCHEME);
		$host = parse_url($url, PHP_URL_HOST);
		$path = parse_url($url, PHP_URL_PATH);
		$query = parse_url($url, PHP_URL_QUERY);
		
		parse_str($query, $queries);

		$queries['cursor'] = $this->getNext();
		$queries['limit'] = $this->getLimit($url);
		$queries['previous'] = $this->getCurrent();
		$queries['direction'] = 'next';

		$query = http_build_query($queries);

		return $scheme.'://'.$host.$path.'?'.urldecode($query);
	}
	
    /**
     * Returns the limit
     *
     * @return int
     */
	public function getLimit($url) 
	{
		$query = parse_url($url, PHP_URL_QUERY);
		
		parse_str($query, $queries);
		
		try {
			$limit = $queries['limit'];
		} catch (\Exception $e) {	
			$limit = 10;
		}
		
		return $limit;
	}
}
