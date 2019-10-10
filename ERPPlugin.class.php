<?php

require_once __DIR__."/lib/ERPForm.php";
require_once __DIR__."/lib/SQLQuery.php";
if (version_compare(phpversion(), "7.0", ">=")) {
    require_once __DIR__ . "/lib/PseudoSORM.php";
} else {
    require_once __DIR__ . "/lib/5xPseudoSORM.php";
}
require_once __DIR__."/lib/formelements/ERPFormElement.interface.php";
foreach (scandir(__DIR__."/lib/formelements") as $file) {
    if ($file[0] !== ".") {
        include_once __DIR__."/lib/formelements/".$file;
    }
}
require_once __DIR__."/lib/filter/ERPFilter.interface.php";
foreach (scandir(__DIR__."/lib/filter") as $file) {
    if ($file[0] !== ".") {
        include_once __DIR__."/lib/filter/".$file;
    }
}


class ERPPlugin extends StudIPPlugin implements SystemPlugin
{

    public function __construct()
    {
        parent::__construct();
        PageLayout::addScript($this->getPluginURL()."/assets/erp.js");
        $this->addStylesheet("assets/erp.less");
        if ($GLOBALS['perm']->have_perm("root")) {
            $nav = new Navigation(_("Formulare"), PluginEngine::getURL($this, array(), "admin/overview"));
            Navigation::addItem("/admin/config/forms", $nav);
        }
        foreach (ERPForm::findMine() as $form) {
            if (Navigation::hasItem($form['navigation'])) {
                $nav = new Navigation($form['name'], PluginEngine::getURL($this, array(), "form/overview/".$form->getId()));
                if ($form['navigation'] !== "/start") {
                    $nav->setImage(Icon::create($form['icon'], "navigation"));
                }
                Navigation::addItem($form['navigation']."/".$form->getId(), $nav);
                if ($form['navigation'] === "/start") {
                    $nav2 = clone $nav;
                    Navigation::addItem("/".$form->getId(), $nav2);
                }
            }
        }
    }
}