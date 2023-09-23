<?php
class Point {
    public $x, $y;

    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
}

class Line {
    public $start, $end;

    public function __construct(Point $start, Point $end) {
        $this->start = $start;
        $this->end = $end;
    }
}

function sweepIntersections($lines) {
    $intersections = [];

    foreach ($lines as $line) {
        $intersections[] = $line->start;
        $intersections[] = $line->end;
    }

    usort($intersections, function ($a, $b) {
        if ($a->x == $b->x) {
            return $a->y - $b->y;
        }
        return $a->x - $b->x;
    });

    $activeLines = [];

    foreach ($intersections as $point) {
        foreach ($lines as $line) {
            if ($line->start->x <= $point->x && $line->end->x > $point->x) {
                $activeLines[] = $line;
            }
        }

        foreach ($activeLines as $key => $activeLine) {
            if ($activeLine->end->x <= $point->x) {
                unset($activeLines[$key]);
            }
        }

        for ($i = 0; $i < count($activeLines) - 1; $i++) {
            for ($j = $i + 1; $j < count($activeLines); $j++) {
                $intersection = findIntersection($activeLines[$i], $activeLines[$j]);
                if ($intersection) {
                    $intersections[] = $intersection;
                }
            }
        }
    }

    return $intersections;
}

function findIntersection(Line $line1, Line $line2) {
    $x1 = $line1->start->x;
    $y1 = $line1->start->y;
    $x2 = $line1->end->x;
    $y2 = $line1->end->y;

    $x3 = $line2->start->x;
    $y3 = $line2->start->y;
    $x4 = $line2->end->x;
    $y4 = $line2->end->y;

    $denominator = ($x1 - $x2) * ($y3 - $y4) - ($y1 - $y2) * ($x3 - $x4);
    if ($denominator == 0) {
        return null;
    } else {
        $t = (($x1 - $x3) * ($y3 - $y4) - ($y1 - $y3) * ($x3 - $x4)) / $denominator;
        $u = -(($x1 - $x2) * ($y1 - $y3) - ($y1 - $y2) * ($x1 - $x3)) / $denominator;
        if ($t >= 0 && $t <= 1 && $u >= 0 && $u <= 1) {
            $intersectionX = $x1 + $t * ($x2 - $x1);
            $intersectionY = $y1 + $t * ($y2 - $y1);
            return new Point($intersectionX, $intersectionY);
        } else {
            return null;
        }
    }
}

$lines = [
    new Line(new Point(1, 2), new Point(4, 2)),
    new Line(new Point(2, 1), new Point(2, 4)),
    new Line(new Point(3, 1), new Point(3, 4)),
];

$intersections = sweepIntersections($lines);

echo "Titik potong:\n";
foreach ($intersections as $intersection) {
    echo "({$intersection->x}, {$intersection->y})\n";
}

?>