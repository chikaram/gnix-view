<?php
/**
 * Interface for the escaper class for Gnix_View_AutoEscaper.
 *
 * @copyright   Copyright 2010, GMO Media, Inc. (http://www.gmo-media.jp)
 * @category    Gnix
 * @package     Gnix_View
 * @license     http://www.gmo-media.jp/licence/mit.html   MIT License
 * @author      Chikara Miyake <chikara.miyake@gmo-media.jp>
 */
interface Gnix_View_AutoEscaper_Escaper_Interface
{
    public function escape($value);

    public function unescape($value);
}
