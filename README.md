Contao Zurb Foundation Integration
===============

A set of tools for Contao Open Source CMS to utilize the Foundation responsive framework.

The latest version is packaged as a Symfony Bundle and uses Foundation for Sites v6.5.x

You will need to add the following to your AppKernel.php file's `registerBundles` method, and making sure to use the `ContaoModuleBundle` class:

`new Rhyme\ContaoZurbFoundationBundle\RhymeContaoZurbFoundationBundle(),
new ContaoModuleBundle('multicolumnwizard', $this->getRootDir()),`

Currently there is an issue with the leafo/scssphp package, which you can see the fix here:
https://github.com/leafo/scssphp/issues/446

Getting 404 errors with the Foundation javascript? You may need to run `php bin/console rhymecontaozurbfoundation:symlinks` from the console.