<?php
class Rule
{
    public $name;
    public $conditions;
    public $conclusion;

    public function __construct($name, $conditions, $conclusion)
    {
        $this->name = $name;
        $this->conditions = $conditions;
        $this->conclusion = $conclusion;
    }
}

class KnowledgeBase
{
    public $facts;
    public $rules;

    public function __construct()
    {
        $this->facts = [];
        $this->rules = [];
    }

    public function addFact($fact)
    {
        $this->facts[] = $fact;
    }

    public function addRule($rule)
    {
        $this->rules[] = $rule;
    }

    public function applyRules()
    {
        $conclusions = [];
        foreach ($this->rules as $rule) {
            if ($this->isRuleApplicable($rule) && !$this->isConclusionKnown($rule->conclusion)) {
                $conclusions[] = $rule->conclusion;
                $this->facts[] = $rule->conclusion;
            }
        }
        return $conclusions;
    }

    private function isRuleApplicable($rule)
    {
        foreach ($rule->conditions as $condition) {
            if (!$this->isFactKnown($condition)) {
                return false;
            }
        }
        return true;
    }

    private function isFactKnown($fact)
    {
        return in_array($fact, $this->facts);
    }

    private function isConclusionKnown($conclusion)
    {
        return in_array($conclusion, $this->facts);
    }
}

$kb = new KnowledgeBase();
$kb->addFact('Fakta1');
$kb->addFact('Fakta2');
$kb->addFact('Fakta4');

$rule1 = new Rule('Rule 1', ['Fakta1', 'Fakta2'], 'Kesimpulan1');
$rule2 = new Rule('Rule 2', ['Fakta3', 'Fakta4'], 'Kesimpulan2');

$kb->addRule($rule1);
$kb->addRule($rule2);

$conclusions = $kb->applyRules();

if (!empty($conclusions)) {
    echo "Kesimpulan yang didapat: " . implode(', ', $conclusions);
} else {
    echo "Tidak ada kesimpulan baru yang bisa diambil.";
}
