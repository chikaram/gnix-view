<?php
// Sample Class
class Gnix_View_AutoEscaper_Sample implements Gnix_View_AutoEscaper_Escaper_Interface
{
    public function escape($value)
    {
        return htmlentities($value, ENT_QUOTES);
    }

    public function unescape($value)
    {
        return html_entity_decode($value, ENT_QUOTES);
    }
}
