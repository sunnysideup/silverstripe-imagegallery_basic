<?php

class ImageGalleryEntry extends DataObject
{
    private static $singular_name = "Image Gallery Picture";

    private static $plural_name = "Image Gallery Pictures";

    private static $db = array(
        "Title" => "Varchar(100)",
        "Sort" => "Int"
    );

    private static $has_one = array(
        "Parent" => "SiteTree",
        "Image" => "Image"
    );

    private static $searchable_fields = array(
        "Title" => "PartialMatchFilter"
    );

    private static $summary_fields = array(
        "Image.CMSThumbNail" => "Image",
        "Title" => "Title"
    );

    private static $field_labels = array(
        "Sort" => "Sorting Index Number (lower numbers show first)"
    );

    //CRUD settings

    private static $default_sort = "Sort ASC, Title ASC";

    private static $defaults = array(
        "Sort" => 100
    );

    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->Sort = 100;
    }
}
