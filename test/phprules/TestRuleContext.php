<?php

use phprules\SingleRule;
use phprules\RuleContext;
use phprules\Operator;

class TestRuleContext extends UnitTestCase {

    public function testIncompleteRuleContext() {
        $rule = new SingleRule('foo');
        $rule->addVariable('var1');
        $rule->addVariable('var2');
        $rule->addOperator(Operator::EQUAL_TO);

        // the actual values...
        $ruleContext = new RuleContext();
        $ruleContext->addVariable('var1', 'foo');

        try {
            $proposition = $rule->evaluate($ruleContext);
            $this->fail('expected incomplete context exception');
        } catch (Exception $e) {
            $this->assertEqual('Incomplete rule context, missing: var2', $e->getMessage());
        }

        $ruleContext->addVariable('var2', 'bar');
        // try again
        try {
            $proposition = $rule->evaluate($ruleContext);
            $this->assertFalse($proposition->value);
        } catch (Exception $e) {
            $this->fail('unexpected exception: '.$e->getMessage());
        }

    }

}