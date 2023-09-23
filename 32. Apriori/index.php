<?php

$transactions = array(
    array("MataKuliah1", "MataKuliah2", "MataKuliah3"),
    array("MataKuliah2", "MataKuliah3", "MataKuliah4"),
    array("MataKuliah1", "MataKuliah3", "MataKuliah5"),
    array("MataKuliah2", "MataKuliah4"),
    array("MataKuliah1", "MataKuliah3", "MataKuliah4"),
);

$minSupport = 0.2;
$minConfidence = 0.5;

function apriori($transactions, $minSupport, $minConfidence) {
    $totalTransactions = count($transactions);

    $minSupportCount = $totalTransactions * $minSupport;

    $itemSupport = array();

    foreach ($transactions as $transaction) {
        foreach ($transaction as $item) {
            if (!isset($itemSupport[$item])) {
                $itemSupport[$item] = 0;
            }
            $itemSupport[$item]++;
        }
    }

    $associationRules = array();

    foreach ($transactions as $transaction) {
        $transactionCount = count($transaction);
        for ($i = 0; $i < $transactionCount; $i++) {
            $lhs = $transaction[$i];
            $lhsSupport = $itemSupport[$lhs];

            for ($j = 0; $j < $transactionCount; $j++) {
                if ($j != $i) {
                    $rhs = $transaction[$j];
                    $rhsSupport = $itemSupport[$rhs];

                    $confidence = $lhsSupport / $rhsSupport;

                    if ($confidence >= $minConfidence) {
                        $associationRules[] = array(
                            'lhs' => array($lhs),
                            'rhs' => array($rhs),
                            'support' => $lhsSupport / $totalTransactions,
                            'confidence' => $confidence,
                        );
                    }
                }
            }
        }
    }

    return $associationRules;
}

$associationRules = apriori($transactions, $minSupport, $minConfidence);

foreach ($associationRules as $rule) {
    echo "Rule: " . implode(" => ", $rule['lhs']) . " => " . implode(", ", $rule['rhs']) . "<hr>";
    echo "Support: " . $rule['support'] . "<hr>";
    echo "Confidence: " . $rule['confidence'] . "<hr><hr>";
}
