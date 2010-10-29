<?php
/**
 * Default escaper class for Gnix_View_AutoEscaper.
 *
 * @copyright   Copyright 2010, GMO Media, Inc. (http://www.gmo-media.jp)
 * @category    Gnix
 * @package     Gnix_View
 * @license     http://www.gmo-media.jp/licence/mit.html   MIT License
 * @author      Chikara Miyake <chikara.miyake@gmo-media.jp>
 */
class Gnix_View_AutoEscaper_Escaper implements Gnix_View_AutoEscaper_Escaper_Interface
{
    public function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    public function unescape($value)
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }
}
