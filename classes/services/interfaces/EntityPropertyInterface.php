<?php
/**
 * @file classes/services/interfaces/EntityPropertyInterface.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class EntityPropertyInterface
 * @ingroup services_interfaces
 *
 * @brief An interface describing the methods a service class will implement to
 *  convert an entity into an assoc array of properties. These methods are
 *  typically evoked when producing a response to an API request.
 */

namespace PKP\services\interfaces;

interface EntityPropertyInterface
{
    /**
     * Returns the values for the requested list of properties
     *
     * @param object $entity The object to convert
     * @param array $props The properties to include in the result
     * @param array $args Additional variable which may be required
     *		$args['request'] PKPRequest Required
     *		$args['slimRequest'] SlimRequest
     *
     * @return array
     */
    public function getProperties($entity, $props, $args = null);

    /**
     * Returns summary properties for an entity
     *
     * @param object $entity The object to convert
     * @param array $args Additional variables which may be required
     *		$args['request'] PKPRequest Required
     *		$args['slimRequest'] SlimRequest
     *
     * @return array
     */
    public function getSummaryProperties($entity, $args = null);

    /**
     * Returns full properties for an entity
     *
     * @param object $entity The object to convert
     * @param array $args Additional variable which may be required
     *		$args['request'] PKPRequest Required
     *		$args['slimRequest'] SlimRequest
     *
     * @return array
     */
    public function getFullProperties($entity, $args = null);
}
