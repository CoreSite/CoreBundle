Установка и подключение
=======================

Установка:
----------

.. code-block:: bash

    $ composer require coresite/corebundle

Подключение:
------------

.. code-block:: php

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