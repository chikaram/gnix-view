Gnix_View_AutoEscaper
======


Gnix_View_AutoEscaper is an auto HTML escaper for Zend_View.
All the tricks are in the class - [Gnix_View_AutoEscaper_Container](http://github.com/chikaram/gnix-view/blob/master/library/Gnix/View/AutoEscaper/Container.php).

## How to use

You need:

  - ZendFramework (a newer one)
  - PHP >= 5.2

Write the code below before you start MVC.

    $view = new Gnix_View_AutoEscaper(); 
    Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->setView($view);

That's all!
