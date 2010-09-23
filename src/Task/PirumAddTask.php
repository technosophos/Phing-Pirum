<?php

require_once 'phing/Task.php';

class PirumAddTask extends Task {
  
  protected $target = NULL;
  protected $package = NULL;
  
  public function init(){
    // Find and include 'pirum'
    require_once '/usr/bin/pirum';
  }
  public function main(){
    
    if (empty($this->target) || !is_dir($target)) {
      throw new BuildException('You must specify a directory using \'targetdir\'.');
    }
    if (empty($this->package) || !is_file($package)) {
      throw new BuildException('You must specify a PEAR package using \'packagefile\'');
    }
    
    $options = array('pirum', 'add', $this->target, $this->package);
    $pirum = new Pirum_CLI($options);
    
    $exitCode = $pirum->run();
    
    if (!empty($exitCode)) {
      throw new BuildException('Pirum could not build a package.');
    }
    else {
      $this->log("Package has been registered with Pirum.", Project::MSG_INFO);
    }
  }
  
  public function setTargetDir($targetDir) {
    $this->target = $targetDir;
  }
  
  public function setPackageFile($file) {
    $this->package = $file;
  }
}