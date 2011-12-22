<?php

namespace PhpRestService\Resource\Formatter;

interface FormatterInterface {

    public static function dataUrl($object);
    public static function dataBasic($object);
    public static function dataExtended($object);

    public static function formatItem($object);
    public static function formatCollection($objects);

}