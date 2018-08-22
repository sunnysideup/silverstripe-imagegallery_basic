<?php

class ImageGalleryPage extends Page
{
    private static $icon = "imagegallery_basic/images/treeicons/ImageGalleryPage";

    private static $allowed_children = array("ImageGalleryPage"); //can also be "none";

    private static $default_child = "ImageGalleryPage";

    private static $description = "Page used to display images in a gallery";

    private static $has_one = array(
        "AutomaticallyIncludedFolder" => "Folder"
    );

    private static $has_many = array(
        "ImageGalleryEntries" => "ImageGalleryEntry"
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Gallery", $treeDropdowField = TreeDropdownField::create($name = "AutomaticallyIncludedFolderID", $title = "Quick Add from Folder", $sourceObjectName = "Folder"));
        $treeDropdowField->setRightTitle('
            Add a folder here to add a bunch of images all at once.<br />
            <a href="/admin/assets/show/'.$this->AutomaticallyIncludedFolderID.'">see files and images</a> section to add, remove and edit images in a folder before selecting one here.
            <br />
            Once added, you can edit the images below as you see fit.
        ');
        $gridField = new GridField('images', 'Linked images', $this->ImageGalleryEntries(), GridFieldConfig_RelationEditor::create());
        $fields->addFieldToTab("Root.Gallery", $gridField);
        if (class_exists("DataObjectSorterController")) {
            $fields->addFieldToTab(
                "Root.Gallery",
                LiteralField::create(
                    "ImageGalleryEntrySorter",
                    DataObjectSorterController::popup_link(
                        "ImageGalleryEntry",
                        $filterField = "ParentID",
                        $filterValue = $this->ID,
                        $linkText = "Sort Items",
                        $titleField = "FullTitle"
                        )
                    )
            );
        } else {
            $fields->addFieldToTab("Root.Gallery", new NumericField($name = "Sort", "Sort index number (the lower the number, the earlier it shows up"));
        }
        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $imageAdded = false;
        if ($this->AutomaticallyIncludedFolderID) {
            if ($folder = Folder::get()->byID($this->AutomaticallyIncludedFolderID)) {
                if ($files = Image::get()->filter("ParentID", $folder->ID)) {
                    foreach ($files as $file) {
                        if (ImageGalleryEntry::get()->filter(array("ImageID" => $file->ID, "ParentID" => $this->ID))->count()) {
                            //do nothing
                            //debug::log("already exists");
                        } else {
                            $ImageGalleryEntry = new ImageGalleryEntry();
                            $ImageGalleryEntry->Title = $file->Title;
                            $ImageGalleryEntry->ImageID = $file->ID;
                            $ImageGalleryEntry->ParentID = $this->ID;
                            $ImageGalleryEntry->write();
                            $imageAdded = true;
                            //debug::log("writing");
                        }
                    }
                } else {
                    //debug::log("D");
                }
            } else {
                //debug::log("C");
            }
        } else {
            //debug::log("B");
        }
        if ($ImageGalleryEntries = ImageGalleryEntry::get()->filter(array("ParentID" => $this->ID))) {
            foreach ($ImageGalleryEntries as $ImageGalleryEntry) {
                $image = Image::get()
                    ->filter(array("ID" => $ImageGalleryEntry->ImageID))
                    ->exclude(array("Title" => $ImageGalleryEntry->Title))
                    ->First();
                if ($image) {
                    $image->Title = $image->Name = $ImageGalleryEntry->Title;
                    $image->write();
                }
            }
        }
        if ($imageAdded) {
            //LeftAndMain::force_reload();
        }
        $this->AutomaticallyIncludedFolderID = 0;
    }

    public function NextGallery()
    {
        $pages = ImageGalleryPage::get()
            ->exclude(array("ID" => $this->ID))
            ->where("TimeDiff(\"Created\",'".$this->Created."') > 0")
            ->sort("Created", "ASC")
            ->limit(1);
        if ($pages) {
            foreach ($pages as $page) {
                return $page;
            }
        }
    }

    public function PreviousGallery()
    {
        $pages = ImageGalleryPage::get()
            ->exclude(array("ID" => $this->ID))
            ->where("TimeDiff(\"Created\",'".$this->Created."') < 0")
            ->sort("Created", "DESC")
            ->limit(1);
        if ($pages) {
            foreach ($pages as $page) {
                return $page;
            }
        }
    }
}

class ImageGalleryPage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        "updateimagegalleryentries" => "ADMIN"
    );

    public function init()
    {
        parent::init();
        if (class_exists("PrettyPhoto")) {
            PrettyPhoto::include_code();
        }
    }

    public function updateimagegalleryentries()
    {
        $this->onBeforeWrite();
        return array();
    }
}
