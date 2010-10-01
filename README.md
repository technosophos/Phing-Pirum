# Pirum Phing Tasks

This defines [Phing](http://phing.info) build system tasks for managing a PEAR server with [Pirum](http://pirum-project.org).

## Installation

Via Pear:

    $ pear channel-discover pear.querypath.org
    $ pear install querypath/Phing-Pirum

From there, you should be able to import the Pirum tasks in Phing build.xml files.

PRERELEASE:

If  you are using this in its pre-1.0.0 state, you may need to install from GitHub by cloning this repository. You may also be able to get a download from [the project download page](http://github.com/technosophos/Phing-Pirum/downloads).

## Usage

Using Phing-Pirum is simple. Once Phing-Pirum is installed, you simply need to make the tasks available in your `build.xml` file, and then you can use them.

### Making them available

Just add this near the top of your `build.xml`:

    <!-- includepath classpath="path/to/PhingPirum"/ -->
    <taskdef classname="PhingPirum.Task.PirumBuildTask" name="pirumbuild"/>
    <taskdef classname="PhingPirum.Task.PirumAddTask" name="pirumadd"/>
    
You will only need to use the `includepath` element if your Phing system cannot find the `PirumBuildTask` or the `PirumAddTask` on its own.

### Setting up a new Pirum channel

Setting up a Pirum channel is well-documented by the [Pirum project](http://pirum-project.org). Here's the short version:

  1. Create a directory for your Pirum channel: `myProject/pear`
  2. Add a `pirum.xml` file into the channel directory. You can copy `Phing-Pirum/tests/pirum.xml`

### Building a channel in `build.xml`

To build a channel in your `build.xml`, just add this task to a target:

    <pirumbuild targetdir="path/to/channel/directory" />
    
Given our example above, we could build the channel using this simple target:

    <target name="buildChannel">
      <pirumbuild targetdir="myProject/pear" />
    </target>

That will build a new channel when you execute `phing buildChannel`.

### Adding a package to a channel

The Pirum Add Task adds an existing PEAR package to a channel. (See the Phing PearPackage2Task for an example of transforming your source into a PEAR package.)

Once you have a channel in place, you can very simply add a pre-build PEAR package to the channel using the `pirumadd` target.

    <pirumadd targetdir="path/to/channel/directory" packagefile="./Foo-1.0.0.tgz"/>

The above adds the package `Foo-1.0.0.tgz` to the PEAR channel. Let's look at the above example extended to add a package:

    <target name="buildChannel">
      <property name="channel" value="myProject/pear"/>
      <pirumbuild targetdir="${channel}" />
      <pirumadd targetdir="${channel}" packagefile="./Foo-1.0.0.tgz"/>
    </target>

This example shows how we can first build a channel, and then add the `Foo-1.0.0` package to that channel.

### Moving on...

Once you have your PEAR channel updated with a new package, you can copy the entire channel directory to your PEAR server and begin serving your packages.