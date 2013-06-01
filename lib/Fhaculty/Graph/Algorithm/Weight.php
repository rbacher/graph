<?php

namespace Fhaculty\Graph\Algorithm;

use Fhaculty\Graph\Set;

use Fhaculty\Graph\Algorithm\Base;

class Weight extends Base
{
    private $set;

    public function __construct(Set $graphOrWalk)
    {
        $this->set = $graphOrWalk;
    }

    /**
     * checks whether this graph has any weighted edges
     *
     * edges usually have no weight attached. a weight explicitly set to (int) 0
     * will be considered as 'weighted'.
     *
     * @return boolean
     * @uses Edge::getWeight()
     */
    public function isWeighted()
    {
        foreach ($this->set->getEdges() as $edge) {
            if ($edge->getWeight() !== NULL) {
                return true;
            }
        }

        return false;
    }

    /**
     * get total weight of graph (sum of weight of all edges)
     *
     * edges with no weight assigned will evaluate to weight (int) 0. thus an
     * unweighted graph (see isWeighted()) will return total weight of (int) 0.
     *
     * returned weight can also be negative or (int) 0 if edges have been
     * assigned a negative weight or a weight of (int) 0.
     *
     * @return float total weight
     * @see self::isWeighted()
     * @uses Edge::getWeight()
     */
    public function getWeight()
    {
        $weight = 0;
        foreach ($this->set->getEdges() as $edge) {
            $w = $edge->getWeight();
            if ($w !== NULL) {
                $weight += $w;
            }
        }

        return $weight;
    }

    /**
     * get minimum weight assigned to all edges
     *
     * minimum weight is often needed because some algorithms do not support
     * negative weights or edges with zero weight.
     *
     * edges with NO (null) weight will NOT be considered for the minimum weight.
     *
     * @return float|NULL minimum edge weight or NULL if graph is not weighted or empty
     */
    public function getWeightMin()
    {
        $min = NULL;
        foreach ($this->set->getEdges() as $edge) {
            $weight = $edge->getWeight();
            if ($weight !== null && ($min === NULL || $weight < $min)) {
                $min = $weight;
            }
        }

        return $min;
    }

    /**
     * get total weight of current flow (sum of all edges flow(e) * weight(e))
     *
     * @return float
     * @see Graph::getWeight() to just get the sum of all edges' weights
     * @uses Edge::getFlow()
     * @uses Edge::getWeight()
     */
    public function getWeightFlow()
    {
        $sum = 0;
        foreach ($this->set->getEdges() as $edge) {
            $sum += $edge->getFlow() * $edge->getWeight();
        }

        return $sum;
    }
}
