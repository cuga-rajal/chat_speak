# chat_speak
Chatter v1.3 Notes
Cuga Rajal, August 29, 2023

"chatter.php" is a shell script that can be used to speak local chat of Firestorm
on macOS systems, using the built-in text-to-speech feature of macOS. It should
work on macOS versions 10.15 and later.

Version 1.3 is an update compatible with macOS Ventura (macOS 13) and adds bug fixes.

Get the latest version of the script from: https://github.com/cuga-rajal

How to set up:

1) In macOS 12 or later, go to System Preferences -> Accessibility -> Spoken Content

(In macOS 10.12 to 10.15, go to System Preferences -> Accessibility -> Speech)
    
Click the System Voice drop-down menu and select Customize at the bottom of the
list. In the window that appears, select the voices you with to use.
On macOS Ventura (macOS 13) the Siri voices cannot be used.

Check the list of $voices in the chatter.php script and adjust as needed to match 
the enabled voices on your system.

2) The program requires PHP. On macOS 12 or later this must be installed with Homebrew.

	brew install php
	
Check that php is installed at /opt/homebrew/bin/php

3) In Firestorm, go to the Preferences window and select Privacy -> Logs & Transcripts

Check the checkbox "Save nearby chat transcript" 

4) Log in to Second Life or Opensim if you aren't already

5) Run the pre-compiled application provided or run the script in a terminal window.

To run the script in a terminal window:

Open a window for the Terminal program and type

	php [full path to chatter.php]

for example, if you place the script on your desktop, you could use:

    php ~/Desktop/chatter.php

You should begin to hear the computer speak each line of local chat from other avatars. 

The file "Chatter.app.zip" in the repository is a ZIP archive of an app wrapper for the program.
Just unzip and double-click to start.

It was created using Platypus, https://www.sveinbjorn.org/platypus

The script filters out some system messages that appear in local chat. It only supports English at this time.

This is a work in progress. Please notify me of bugs or feature requests.

Thanks,

Cuga Rajal (Second Life and OSGrid)
cugarajal@gmail.com
