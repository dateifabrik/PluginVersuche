<?php
namespace Shopware\Themes\LizenzTheme;

use Doctrine\Common\Collections\ArrayCollection;
use Shopware\Components\Form as Form;
use Shopware\Components\Theme\ConfigSet;

class Theme extends \Shopware\Components\Theme
{
    /** @var string Defines the parent theme */
    protected $extend = 'Responsive';

    /** @var string Defines the human readable name */
    protected $name = 'LizenzTheme';

    /** @var string Description of the theme */
    protected $description = 'Plugin Test mit Theme für Lizenzierung';

    /** @var string The author of the theme */
    protected $author = 'dateifabrik';

    /** @var string License of the theme */
    protected $license = 'MIT';
}