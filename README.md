Gnix_View_AutoEscaper
======


Gnix_View_AutoEscaper is an auto HTML escaper module for Zend_View. 
All the tricks are in [Gnix_View_AutoEscaper_Container](http://github.com/chikaram/gnix-view/blob/master/library/Gnix/View/AutoEscaper/Container.php).

## How to use

You need:

  - ZendFramework (a newer one, please)
  - PHP >= 5.2

Write the code below before you start MVC:

    $view = new Gnix_View_AutoEscaper(); 
    Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->setView($view);

That's all and you'll be free from '$this->escape()' that messes up your view templates!

    // output: <p>&lt;script&gt;alert(&#039;XSS&#039;)&lt;/script&gt;</p>
    <p><?= $this->tweet->getText() ?></p>
    
    // output: <p><script>alert('XSS')</script></p>
    <p><?= $this->unescape($this->tweet->getText()) ?></p>
