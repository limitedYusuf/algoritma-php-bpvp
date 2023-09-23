<?php
class Dijkstra {
    private $graph;
    private $visited = [];
    private $distance = [];
    private $previous = [];

    public function __construct($graph) {
        $this->graph = $graph;
    }

    private function findClosestNode() {
        $closestNode = null;
        $shortestDistance = INF;

        foreach ($this->distance as $node => $distance) {
            if (!$this->visited[$node] && $distance < $shortestDistance) {
                $closestNode = $node;
                $shortestDistance = $distance;
            }
        }

        return $closestNode;
    }

    public function calculateShortestPathByCost($startNode) {
        foreach ($this->graph as $node => $neighbors) {
            $this->distance[$node] = INF;
            $this->visited[$node] = false;
            $this->previous[$node] = null;
        }

        $this->distance[$startNode] = 0;

        for ($i = 0; $i < count($this->graph); $i++) {
            $currentNode = $this->findClosestNode();
            $this->visited[$currentNode] = true;

            foreach ($this->graph[$currentNode] as $neighbor => $cost) {
                $potentialDistance = $this->distance[$currentNode] + $cost;

                if ($potentialDistance < $this->distance[$neighbor]) {
                    $this->distance[$neighbor] = $potentialDistance;
                    $this->previous[$neighbor] = $currentNode;
                }
            }
        }
    }

    public function getShortestPath($endNode) {
        $path = [];
        $currentNode = $endNode;

        while ($currentNode !== null) {
            array_unshift($path, $currentNode);
            $currentNode = $this->previous[$currentNode];
        }

        return $path;
    }
}

$graph = [
    'A' => ['B' => 10, 'C' => 20],
    'B' => ['A' => 10, 'C' => 15],
    'C' => ['A' => 20, 'B' => 15],
];

$dijkstra = new Dijkstra($graph);
$startNode = 'A';
$endNode = 'C';

$dijkstra->calculateShortestPathByCost($startNode);
$shortestPath = $dijkstra->getShortestPath($endNode);

echo 'Jalur terpendek dari ' . $startNode . ' ke ' . $endNode . ' berdasarkan biaya adalah: ' . implode(' -> ', $shortestPath) . "\n";
