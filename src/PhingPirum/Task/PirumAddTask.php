<?php

require_once 'phing/Task.php';

class PirumAddTask extends Task {
  
  protected $target = NULL;
  protected $package = NULL;
  
  protected $pirumPath = '/usr/bin/pirum';
  
  public function init(){
    
  }
  public function main(){
    
    // Find and include 'pirum'
    require_once $this->pirumPath;
    
    if (empty($this->target)) {
      throw new BuildException('You must specify a directory using \'targetdir\'.');
    }elseif (!is_dir($this->target)) {
      throw new BuildException('\'targetdir\' does not appear to be a directory: ' . $this->target);
    }
    
    if (empty($this->package)) {
      throw new BuildException('You must specify a PEAR package using \'packagefile\'');
    }
    elseif (!is_file($this->package)) {
      throw new BuildException('\'packagefile\' does not appear to be a file: '. $this->package);
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
  
  public function setPirumPath($filename) {
    $this->pirumPath = $filename;
  }
}