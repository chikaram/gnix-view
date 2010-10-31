Gnix_View_AutoEscaper
======


Gnix_View_AutoEscaper is an auto HTML escaper module for Zend_View. 
All the tricks are in [Gnix_View_AutoEscaper_Container](http://github.com/chikaram/gnix-view/blob/master/library/Gnix/View/AutoEscaper/Container.php).


## First of all

There is another (possibly better) way to escape template values automatically. It's Zend_View_Stream.
Read this [Auto HTML escaper module for Zend_View](http://zend-framework-community.634137.n4.nabble.com/Auto-HTML-escaper-module-for-Zend-View-td3019090.html) (esp. Andrew Collington-2's reply) and choose what is more suitable for your project.

Anyway, however, I hope this 'Gnix_View_AutoEscaper' will be the evidence of how powerful SPL and IteratorAggregate are.


## How to use

You need:

  - ZendFramework (a newer one, please)
  - PHP >= 5.2

Write the code below before you start MVC:

    $view = new Gnix_View_AutoEscaper(); 
    Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->setView($view);

That's all and you'll be free from '$this->escape()' that messes up your view templates!

    <p><?= $this->tweet->getText() ?></p>
    // outputs => <p>&lt;script&gt;alert(&#039;XSS&#039;)&lt;/script&gt;</p>
    
    <p><?= $this->unescape($this->tweet->getText()) ?></p>
    // outputs => <p><script>alert('XSS')</script></p>


## License

    The MIT License
    
    Copyright (c) 2010 GMO Media, Inc.

    Permission is hereby granted, free of charge, to any person obtaining a copy 
    of this software and associated documentation files (the "Software"), to deal 
    in the Software without restriction, including without limitation the rights 
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
    copies of the Software, and to permit persons to whom the Software is 
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in 
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN 
    THE SOFTWARE.
