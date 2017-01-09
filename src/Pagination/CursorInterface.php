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
 * A common interface for cursors to use.
 *
 * @author Isern Palaus <ipalaus@ipalaus.com>
 */
interface CursorInterface
{
    /**
     * Get the current cursor value.
     *
     * @return mixed
     */
    public function getCurrent();

    /**
     * Get the prev cursor value.
     *
     * @return mixed
     */
    public function getPrev();

    /**
     * Get the next cursor value.
     *
     * @return mixed
     */
    public function getNext();

    /**
     * Returns the total items in the current cursor.
     *
     * @return int
     */
    public function getCount();
	
    /**
     * Returns the current URL.
     *
     * @return int
     */
	public function getUrl();
	
    /**
     * Returns the prev URL.
     *
     * @return int
     */
	public function getPrevUrl($url);
	
    /**
     * Returns the next URL.
     *
     * @return int
     */
	public function getNextUrl($url);
	
    /**
     * Returns the limit.
     *
     * @return int
     */
	public function getLimit($url);
	
    /**
     * Returns the minId.
     *
     * @return int
     */
	public function getMinId();
	
    /**
     * Returns the maxId.
     *
     * @return int
     */
	public function getMaxId();
}
