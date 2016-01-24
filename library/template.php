<?php
class		template
{
  private	$_header = 'HeaderView.html';
  private	$_footer = 'FooterView.html';
  private	$data = array();
  private	$flux;
  private	$vue = array();
  private $module = array();
  private	$json = array();
  public	$language;
  private	$KLogger;
  private	$twig;

  /**
   * @fn function __construct($class)
   * @brief 
   * @file template.php
   * 
   * @param class               
   * @return		
   */
  public function __construct($class)
  {
    if (!isset($_SESSION['lang']))
      $_SESSION['lang'] = "FR";
    $this->KLogger = $class['KLogger'];
    $this->root = $class['root'];
    if (isset($_SESSION['__error']) && $_SESSION['__error'])
      {
      	$this->__set("__error", $_SESSION['__error']);
      	$this->KLogger->logInfo("[error] ".$_SESSION['__error']);
      }	
    if (isset($_SESSION['__success']) && $_SESSION['__success'])
      {
      	$this->__set("__success", $_SESSION['__success']);
      	$this->KLogger->logInfo("[success] ".$_SESSION['__success']);
      }
    unset($_SESSION['__error']);
    unset($_SESSION['__success']);

    $loader = new Twig_Loader_Filesystem(PATH_VIEWS);
    $this->twig = new Twig_Environment($loader, array('cache' => false,'charset' => 'UTF-8'));
  }

  /**
   * @fn function redirect($msg, $isError, $url = "SELF")
   * @brief 
   * @file template.php
   * 
   * @param msg         
   * @param isError             
   * @param url         
   * @return		
   */
  public function redirect($msg, $isError, $url = "SELF")
  {
    if ($this->root->isAjax())
      {
	if ($isError)
	  $array = array("_error_" => $msg);
	else
	  $array = array("_success_" => $msg);
	$this->addJSON($array);
	$this->fetchAjax();
	return ;
      }
    if ($isError == TRUE)
      $this->setError($msg);
    else
      $this->setSuccess($msg);
    if ($url == "SELF")
      $url = str_replace("?".$_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);
    $this->KLogger->logInfo("[Redirect] ".$url);
    header("Location: ".$url);
    exit();
  }

  /**
   * @fn function setError($str)
   * @brief 
   * @file template.php
   * 
   * @param str         
   * @return		
   */
  private function setError($str) {$_SESSION['__error'] = $str;}

  /**
   * @fn function setSuccess($str)
   * @brief 
   * @file template.php
   * 
   * @param str         
   * @return		
   */
  private function setSuccess($str) {$_SESSION['__success'] = $str;}

  /**
   * @fn function __get($key)
   * @brief 
   * @file template.php
   * 
   * @param key         
   * @return		
   */
  public function __get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : NULL;
  }

  /**
   * @fn function __set($key, $value)
   * @brief 
   * @file template.php
   * 
   * @param key         
   * @param value               
   * @return		
   */
  public function __set($key, $value) {
    $this->data[$key] = $value;
  }

  /**
   * @fn function fetch($module = "", $disableHeader = FALSE)
   * @brief 
   * @file template.php
   * 
   * @param module              
   * @param disableHeader               
   * @return		
   */
  public function fetch($module = "")
  {
    ob_start();
    $this->loadView($module);
    $this->flux = ob_get_contents();
    ob_end_clean();
  }

  /**
   * @fn function addJSON($array)
   * @brief 
   * @file template.php
   * 
   * @param array               
   * @return		
   */
  private function	json_clean($data)
  {
    if (is_array($data))
      foreach ($data AS $key => $val)
	     $data[$key] = $this->json_clean($val);
    else
      $data = utf8_encode($data);
    return $data;
  }

  public function addJSON($array)
  {
    if (is_array($array))
      {
      	//foreach ($array AS $key => $val)
      	//$array[$key] = $this->json_clean($val);
      	$this->json = array_merge($this->json, $array);
      }
  }
  /**
   * @fn function fetchAjax($module = "")
   * @brief 
   * @file template.php
   * 
   * @param module              
   * @return		
   */
  public function fetchAjax($module = "")
  {
    header("Content-Type: application/json");
    if ($this->countView() > 0)
      {
      	ob_start();
      	$this->loadView($module);
      	$this->json['_html_'] = ob_get_contents();
      	ob_end_clean();
      }
    $this->KLogger->logDebug($this->json);
    echo json_encode($this->json);
    exit;
  }
  public function changeHeader($file)
  {
    if ($file !== false)
    {
      $file .= ".html";
      $this->_header = $file;
    }
    else 
      $this->_header = false;
  }

  public function	changeFooter($file)
  {
    if ($file !== false)
    {
      $file .= ".html";
      $this->_footer = $file;
    }
    else
      $this->_footer = false;
  }
  /**
   * @fn function display()
   * @brief 
   * @file template.php
   * 
   * @param             
   * @return		
   */
  public function display() {echo $this->flux;}

  /**
   * @fn function has($key)
   * @brief 
   * @file template.php
   * 
   * @param key         
   * @return		
   */
  public function has($key) {return isset($this->data[$key]);}

  /**
   * @fn function getData()
   * @brief 
   * @file template.php
   * 
   * @param             
   * @return		
   */
  public function getData() {return $this->data;}

  /**
   * @fn function setView($var)
   * @brief 
   * @file template.php
   * 
   * @param var         
   * @return		
   */
  public function setView($var, $module = FALSE) {
    $this->vue[$var] = $var;
    if ($module === FALSE)
      $module = $this->root->getModule();
    $this->module[$var] = $module;
  }

  /**
   * @fn function countView()
   * @brief 
   * @file template.php
   * 
   * @param             
   * @return		
   */
  public function countView() {
    $i = 0;
    foreach ($this->vue AS $views)
      {
      	$url = $this->module[$views].''.$views.".html";
      	if (file_exists(PATH_VIEWS.$url))
      	  $i++;
      }
    return $i;
  }

  /**
   * @fn function loadView($module, $disableHeader = false)
   * @brief 
   * @file template.php
   * 
   * @param module              
   * @param disableHeader               
   * @return		
   */
  public function loadView($module)
  {
    if ($this->_header !== false && $this->root->isAjax() == false)
      echo $this->twig->render($this->_header, $this->data);
    foreach ($this->vue AS $views)
      {
	     $url = $this->module[$views].''.$views.".html";
    	 if (file_exists(PATH_VIEWS.$url))
    	  {
    	    echo $this->twig->render($url, $this->data);
    	    $this->KLogger->logInfo("[View] ".$views);
    	  }
    	 else
    	  $this->KLogger->logFatal("[View] ".$views);
      }
      if ($this->_footer !== false && $this->root->isAjax() == false)
        echo $this->twig->render($this->_footer, $this->data);
  }

  /**
   * @fn function loadLanguage($controller)
   * @brief 
   * @file template.php
   * 
   * @param lang                
   * @param controller          
   * @return		
   */
  public function       	loadLanguage($controller)
  {
    $lang = (isset($_SESSION['lang'])) ? $_SESSION['lang'] : "FR";
    $url = PATH_LANG.$lang."/".$controller.".php";
    if (!file_exists($url))
      {
	$this->KLogger->logFatal("[Language] ".$controller);
	return;
      }
    else
      $this->KLogger->logInfo("[Language] ".$controller);
    require_once($url);
    if (isset($_) && !is_array($_))
      $_ = array();
    if (is_array($this->language))
      $this->language = array_merge($this->language, $_);
    else
      {
      	$this->language = $_;
      	$this->data['_lang'] = &$this->language;
      }
    unset($_);
    unset($url);
    unset($controller);
  }
}
?>