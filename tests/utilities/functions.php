<?php

/**
 * Create function for Tests
 *
 * @param $class
 * @param array $attributes
 * @return mixed
 */
function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

/**
 * Make function for Tests
 *
 * @param $class
 * @param array $attributes
 * @return mixed
 */
function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}