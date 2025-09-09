<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * The application kernel.
 *
 * This class configures the Symfony application, including bundles,
 * routes, and container services. It extends the base kernel and
 * uses the MicroKernelTrait for simplified setup.
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
