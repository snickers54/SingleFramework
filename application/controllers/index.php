<?php

class indexController extends controller
{
  public function indexAction()
  {
    $this->template->loadLanguage("index");
    $this->template->setView("index");
  }

}
?>
