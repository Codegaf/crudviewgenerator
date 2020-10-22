<?php

namespace Codegaf\CrudViewGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \10codesoftware\Crudgenerator\Skeleton\SkeletonClass
 */
class CrudViewGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'crudviewgenerator';
    }
}
