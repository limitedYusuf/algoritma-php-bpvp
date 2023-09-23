<?php
class Dijkstra {
    private $graph;

    public function __construct($graph) {
        $this->graph = $graph;
    }

    public function shortestPath($start, $end) {
        $distances = array();
        $visited = array();
        $previous = array();

        foreach ($this->graph as $node => $neighbors) {
            $distances[$node] = INF;
            $previous[$node] = null;
        }

        $distances[$start] = 0;
        $queue = $this->graph;

        while ($queue) {
            $min = null;
            foreach (array_keys($queue) as $node) {
                if (!$min || $distances[$node] < $distances[$min]) {
                    $min = $node;
                }
            }

            if ($distances[$min] === INF) {
                break;
            }

            foreach ($this->graph[$min] as $neighbor => $value) {
                $alt = $distances[$min] + $value;
                if ($alt < $distances[$neighbor]) {
                    $distances[$neighbor] = $alt;
                    $previous[$neighbor] = $min;
                }
            }

            unset($queue[$min]);
            $visited[] = $min;
        }

        $path = array();
        $node = $end;

        while ($node !== $start) {
            if ($previous[$node] === null) {
                return null;
            }
            $path[] = $node;
            $node = $previous[$node];
        }

        $path[] = $start;
        return array_reverse($path);
    }
}

$graph = array(
    'A' => array('B' => 1, 'C' => 4),
    'B' => array('A' => 1, 'C' => 2, 'D' => 5),
    'C' => array('A' => 4, 'B' => 2, 'D' => 1),
    'D' => array('B' => 5, 'C' => 1)
);

$dijkstra = new Dijkstra($graph);
$path = $dijkstra->shortestPath('A', 'D');
print_r($path);
