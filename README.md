# CoreBundle

Бандл содержит заготовки для разработки приложений на базе Symfony 3.

Установка и подключение
=======================

Установка:
----------

    $ composer require coresite/corebundle
    
Подключение:
------------

    // app/AppKernel.php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new CoreSite\CoreBundle\CoreSiteCoreBundle(),
            );

            // ...
        }
    }
    
    