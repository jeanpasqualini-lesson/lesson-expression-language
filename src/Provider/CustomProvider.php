<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 3/13/15
 * Time: 2:11 AM
 */
namespace Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class CustomProvider implements ExpressionFunctionProviderInterface {
    /**
     * @return \Symfony\Component\ExpressionLanguage\ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return array(
            new ExpressionFunction(
                "uppercase",
                function($str)
                {
                    return "";
                },
                function($arguments, $str)
                {
                    return strtoupper($str);
                }
            )
        );
        // TODO: Implement getFunctions() method.
    }

}