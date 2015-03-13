<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 3/13/15
 * Time: 1:03 AM
 */
namespace Test;

use Interfaces\TestInterface;
use Provider\CustomProvider;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SerializedParsedExpression;

class Apple
{
    public $variety;

    public function getVariety()
    {
        return $this->variety;
    }
}

class MainTest implements TestInterface {

    public function runTest()
    {
        $this->testOne();

        $this->testThree();

        $this->testFoor();

        $this->testAccessPublicProperties();

        $this->testCallingMethods();

        $this->testFunction();

        $this->testArray();

        $this->testOperator();
    }

    public function testAccessPublicProperties()
    {
        $language = new ExpressionLanguage();

        $apple = new Apple();

        $apple->variety = "Honeycrisp";


        echo $language->evaluate(
                "fruit.variety",
                array(
                    "fruit" => $apple
                )
            ).PHP_EOL;
    }

    public function testCallingMethods()
    {
        $language = new ExpressionLanguage();

        $apple = new Apple();

        $apple->variety = "Honeycrisp";

        echo $language->evaluate(
            "fruit.getVariety()",
            array(
                "fruit" => $apple
            )
        ).PHP_EOL;
    }

    public function testFunction()
    {
        $language = new ExpressionLanguage();

        echo $language->evaluate(
            "constant('ROOT_DIR')"
        ).PHP_EOL;
    }

    public function testArray()
    {
        $language = new ExpressionLanguage();

        $data = array(
            "life" => 10,
            "universe" => 10,
            "everything" => 22
        );

        echo $language->evaluate(
            'data["life"] + data["universe"] + data["everything"]',
            array(
                "data" => $data
            )
        ).PHP_EOL;
    }

    public function testOperator()
    {
        $language = new ExpressionLanguage();

        $data = array(
            "life" => 10,
            "universe" => 10,
            "everything" => 22
        );

        echo $language->evaluate(
            "life + universe + everything",
            $data
        ).PHP_EOL;

        echo var_export($language->evaluate('not ("foo" matches "/bar/")'), true).PHP_EOL;

        echo var_export($language->evaluate(
            "life == everything",
            $data
        ), true).PHP_EOL;

        echo var_export($language->evaluate(
            "life > everything",
            $data
        ), true).PHP_EOL;

        echo var_export($language->evaluate(
            "life < universe or life < everything",
            $data
        ), true).PHP_EOL;

        echo $language->evaluate(
            'firstName~" "~lastName',
            array(
                "firstName" => "Arthur",
                "lastName" => "Dent"
            )
        ).PHP_EOL;

        $user = new \stdClass();

        $user->group = "human_resources";

        $user->age = 34;

        echo var_export($language->evaluate(
            'user.group in ["human_resources", "marketing"]',
            array(
                "user" => $user
            )
        ), true).PHP_EOL;

        echo var_export($language->evaluate(
            "user.age in 18..45",
            array(
                "user" => $user
            )
        ), true);

    }

    public function testOne()
    {
        $language = new ExpressionLanguage();

        echo $language->evaluate("1 + 2").PHP_EOL;
    }

    public function testThree()
    {
        $language = new ExpressionLanguage();

        $serializedEvaluate = $language->parse("1 + 4", array());

        //$expression = new SerializedParsedExpression("", serialize($serializedEvaluate));

        //echo $expression->getNodes()->evaluate();

    }

    public function testFoor()
    {
        $language = new ExpressionLanguage();

        $language->register(
            "lowercase",
            function($str)
            {
                return "(strtolower($str))";
            },
            function($arguments, $str)
            {
                return (is_string($str)) ? strtolower($str) : $str;
            }
        );

        $language->registerProvider(new CustomProvider()).PHP_EOL;

        echo $language->evaluate('lowercase("HELLO")').PHP_EOL;

        echo $language->evaluate("uppercase('hello')").PHP_EOL;
    }

}