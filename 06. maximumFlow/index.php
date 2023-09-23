<?php
class MaximumFlow
{
   private $graph;
   private $source;
   private $sink;

   public function __construct($graph, $source, $sink)
   {
      $this->graph = $graph;
      $this->source = $source;
      $this->sink = $sink;
   }

   private function bfs(&$parent)
   {
      $visited = array_fill(0, count($this->graph), false);
      $queue = new SplQueue();

      $visited[$this->source] = true;
      $queue->enqueue($this->source);

      while (!$queue->isEmpty()) {
         $u = $queue->dequeue();

         foreach ($this->graph[$u] as $v => &$capacity) {
            if (!$visited[$v] && $capacity > 0) {
               $queue->enqueue($v);
               $parent[$v] = $u;
               $visited[$v] = true;
            }
         }
      }

      return $visited[$this->sink];
   }

   public function findMaxFlow()
   {
      $parent = [];
      $maxFlow = 0;

      while ($this->bfs($parent)) {
         $pathFlow = PHP_INT_MAX;
         $s = $this->sink;

         while ($s != $this->source) {
            $u = $parent[$s];
            $pathFlow = min($pathFlow, $this->graph[$u][$s]);
            $s = $u;
         }

         $v = $this->sink;
         while ($v != $this->source) {
            $u = $parent[$v];
            $this->graph[$u][$v] -= $pathFlow;
            if (!isset($this->graph[$v][$u])) {
               $this->graph[$v][$u] = 0;
            }
            $this->graph[$v][$u] += $pathFlow;
            $v = $u;
         }

         $maxFlow += $pathFlow;
      }

      return $maxFlow;
   }
}

$graph = [
   [0, 16, 13, 0, 0, 0],
   [0, 0, 10, 12, 0, 0],
   [0, 4, 0, 0, 14, 0],
   [0, 0, 9, 0, 0, 20],
   [0, 0, 0, 7, 0, 4],
   [0, 0, 0, 0, 0, 0],
   [30, 0, 10, 7, 0, 4],
];

$source = 0;
$sink = 4;

$maxFlowFinder = new MaximumFlow($graph, $source, $sink);
$maxFlow = $maxFlowFinder->findMaxFlow();

echo "Maximum Flow: $maxFlow\n";
