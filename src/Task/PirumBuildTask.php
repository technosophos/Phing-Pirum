<?php

require_once 'phing/Task.php';

class PirumBuildTask extends Task {
  
  protected $target = NULL;
  protected $package = NULL;
  
  public function init(){
    // Find and include 'pirum'
    require_once '/usr/bin/pirum';
  }
  public function main(){
    
    if (empty($this->target)) {
      throw new BuildException('You must specify a directory using \'targetdir\'.');
    }
    if (!is_dir($this->target)) {
      throw new BuildException('Invalid directory:' . $this->target);
    }
    $options = array('pirum', 'build', $this->target);
    $pirum = new Pirum_CLI($options);
    
    $exitCode = $pirum->run();
    
    if (!empty($exitCode)) {
      throw new BuildException('Pirum could not build a channel.');
    }
    else {
      $this->log(sprintf("Channel has been built in '%s'.", $this->target), Project::MSG_INFO);
    }
  }
  
  public function setTargetDir($targetDir) {
    $this->target = $targetDir;
  }
}